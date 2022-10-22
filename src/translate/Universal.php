<?php

namespace Yufu\Baidu\translate;

use Curl\Curl;
use Yufu\Baidu\lib\Config;
use Yufu\Baidu\lib\exceptions\MissingConfigException;
use Yufu\Baidu\lib\exceptions\RequestException;
use Yufu\Baidu\lib\response\TranslateUniversalResponse;

class Universal
{

    /**
     * 通用翻译API HTTPS 地址
     * @var string
     */
    public $gateway = "https://fanyi-api.baidu.com/api/trans/vip/translate";

    /**
     * 响应的结果
     * @var TranslateUniversalResponse
     */
    public $response = null;

    /**
     * 访问频率受限时重试次数
     * @var int
     */
    private $retry_count = 1;

    /**
     * 翻译源语言
     * @var string 可设置为auto
     */
    public $from = 'auto';

    /**
     * 翻译目标语言
     * @var string 不可设置为auto
     */
    public $to = '';

    /**
     * 随机数
     * @var string 可为字母或数字的字符串
     */
    public $salt = '';

    /**
     * 是否显示语音合成资源
     * 仅开通了词典、TTS用户需要填写
     * @var int  0-显示，1-不显示
     */
    public $tts = null;
    /**
     * 是否显示词典资源
     * 仅开通了词典、TTS用户需要填写
     * @var int  0-显示，1-不显示
     */
    public $dict = null;

    /**
     * 判断是否需要使用自定义术语干预API
     * 仅开通了”我的术语库“用户需要填写
     * @var int 1-是，0-否
     */
    public $action = null;

    /**
     * 签名
     * @var string
     */
    public $sign = '';

    /**
     * 请求翻译的内容
     * @var string UTF-8编码
     */
    public $q = '';

    /**
     * APPID
     * @var string 可在管理控制台查看
     */
    private $appid = '';

    /**
     * 签名密钥
     * @var string 可在管理控制台查看
     */
    private $secret = '';

    /**
     * @throws MissingConfigException
     */
    public function __construct()
    {
        $this->appid = Config::get('baidu.translate.appid');
        $this->secret = Config::get('baidu.translate.secret');
        $this->salt || $this->generateSalt();
    }

    /**
     * 参数签名
     * @return void
     */
    private function makeSign()
    {
        $this->sign = md5($this->appid . $this->q . $this->salt . $this->secret);
    }

    /**
     * 签名随机字符串
     * @return void
     */
    private function generateSalt()
    {
        $this->salt = rand(10000, 99999);
    }

    /**
     * 转成请求的参数数组
     * @return array
     */
    private function getParameter()
    {
        $this->generateSalt();
        $this->makeSign();
        $args = [
            'appid' => $this->appid,
            'salt' => $this->salt,
            'q' => $this->q,
            'from' => $this->from,
            'to' => $this->to,
            'sign' => $this->sign
        ];
        if ($this->tts !== null) {
            $args['tts'] = $this->tts;
        }
        if ($this->dict !== null) {
            $args['dict'] = $this->dict;
        }
        if ($this->action !== null) {
            $args['action'] = $this->action;
        }
        return $args;
    }

    /**
     * @param $query
     * @param $to
     * @param $from
     * @return TranslateUniversalResponse|null
     */
    public function request($query, $to, $from = 'auto')
    {
        $this->to = $to;
        $this->from = $from;
        $this->q = $query;
        $curl = new Curl();

        $retry_count = $this->retry_count;
        $result = null;
        $usleep = 0;
        while ($retry_count >= 0 && !$result) {
            try {
                usleep($usleep);
                $response = $curl->get($this->gateway, $this->getParameter());
                $this->response = new TranslateUniversalResponse($response);
                if ($this->response->validate()) {
                    return $this->response;
                }
            } catch (RequestException $e) {
                switch ($e->getCode()) {
                    case 54003:
                        $retry_count--;
                        $usleep = 1000000;
                        break;
                    case 54005:
                        $retry_count--;
                        $usleep = 3000000;
                        break;
                    default:
                }
            }
        }
        return null;
    }
}