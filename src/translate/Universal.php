<?php

namespace Yufu\Baidu\translate;

use Curl\Curl;
use Yufu\Baidu\exceptions\RequestException;
use Yufu\Baidu\request\TranslateUniversalRequest;
use Yufu\Baidu\response\TranslateUniversalResponse;

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
    public $result = null;

    /**
     * 请求的参数
     * @var TranslateUniversalRequest
     */
    public $param = null;

    public function __construct()
    {
        $this->param = new TranslateUniversalRequest();
    }

    /**
     * @param $query
     * @param $to
     * @param $from
     * @return TranslateUniversalResponse|null
     * @throws RequestException
     */
    public function request($query, $to = null, $from = null)
    {
        $this->param->to = $to;
        $this->param->from = $from;
        $this->param->q = $query;
        $curl = new Curl();
        $response = $curl->get($this->gateway, $this->param->toArray());

        $this->result = new TranslateUniversalResponse($response);
        return $this->result;
    }
}