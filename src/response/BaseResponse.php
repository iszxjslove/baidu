<?php

namespace Yufu\Baidu\response;

use Yufu\Baidu\exceptions\RequestException;

class BaseResponse
{
    private $response = null;

    /**
     * @throws RequestException
     */
    public function __construct($response)
    {
        $this->response = (object)$response;
        if (!empty($response->error_code)) {
            throw new RequestException($response->error_msg, $response->error_code);
        }
    }

    public function __get($name)
    {
        return isset($this->response[$name]) ? $this->response[$name] : null;
    }
}