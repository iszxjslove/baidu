<?php

namespace Yufu\Baidu\lib;

use Yufu\Baidu\lib\exceptions\MissingConfigException;

require_once "common.php";

class Config
{
    /**
     * @param $key
     * @param $default
     * @param $required
     * @return array|false|mixed|string|null
     * @throws MissingConfigException
     */
    public static function get($key = null, $default = null, $required = true)
    {
        $value = config($key, $default);
        if (is_null($value) && $required) {
            throw new MissingConfigException("Configuration ${key} is empty");
        }
        return $value;
    }
}