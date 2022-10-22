<?php

namespace Yufu\Baidu\lib\response;

use Yufu\Baidu\lib\exceptions\RequestException;

class BaseResponse
{
    private $response = null;

    public function __construct($response)
    {
        if (is_array($response)) {
            $response = (object)$response;
        }
        $this->response = $response;
    }

    /**
     * @return bool
     * @throws RequestException
     */
    public function validate()
    {
        if (!empty($this->response->error_code)) {
            throw new RequestException($this->response->error_msg, $this->response->error_code);
        }
        return true;
    }

    public function __get($name)
    {
        return isset($this->response->$name) ? $this->response->$name : null;
    }
}

