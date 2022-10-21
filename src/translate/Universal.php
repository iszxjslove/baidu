<?php

namespace Yufu\Baidu\translate;

use Curl\Curl;

class Universal
{
    /**
     * 通用翻译API HTTPS 地址
     * @var string
     */
    public $gateway =  "https://fanyi-api.baidu.com/api/trans/vip/translate";

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
     * 随机数
     * @var string 可为字母或数字的字符串
     */
    public $salt = '';

    /**
     * 签名
     * @var string appid+q+salt+密钥的MD5值
     */
    public $sign = '';

    //以下字段仅开通了词典、TTS用户需要填写
    /**
     * 是否显示语音合成资源
     * @var int  0-显示，1-不显示
     */
    public $tts = null;
    /**
     * 是否显示词典资源
     * @var int  0-显示，1-不显示
     */
    public $dict = null;

    //以下字段仅开通了”我的术语库“用户需要填写
    /**
     * 判断是否需要使用自定义术语干预API
     * @var int 1-是，0-否
     */
    public $action = null;

    public function __construct($appid, $secret)
    {
        $this->appid = $appid;
        $this->secret = $secret;
    }

    public function request($query, $to = null, $from = null)
    {
        $from = $from ?: $this->from;
        $to = $to ?: $this->to;
        $args = [
            'appid' => $this->appid,
            'salt' => $this->salt ?: rand(10000, 99999),
            'q' => $query,
            'from' => $from,
            'to' => $to,
        ];
        $args['sign'] = $this->makeSign($args);
        if ($this->tts !== null) {
            $args['tts'] = $this->tts;
        }
        if ($this->dict !== null) {
            $args['dict'] = $this->dict;
        }
        if ($this->action !== null) {
            $args['action'] = $this->action;
        }

        $curl = new Curl();
        $result = $curl->get($this->gateway, $args);
        var_dump($result);
    }

    public function makeSign($args)
    {
        return md5($args['appid'] . $args['q'] . $args['salt'] . $this->secret);
    }
}