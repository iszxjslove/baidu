<?php

namespace Yufu\Baidu\request;

class TranslateUniversalRequest
{

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

    public function __construct()
    {
        $this->appid = getenv('BAIDU_TRANSLATE_APPID');
        $this->secret = getenv('BAIDU_TRANSLATE_SECRET');
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
    public function toArray()
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
}