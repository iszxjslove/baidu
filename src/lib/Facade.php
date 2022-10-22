<?php

namespace Yufu\Baidu\lib;

class Facade
{
    /**
     * 对象实例
     */
    protected static $instance;

    /**
     * 获取当前容器的实例（单例）
     * @access public
     * @return static
     */
    public static function getInstance()
    {
        if (!static::$instance instanceof self) {
            return new static;
        }
        return static::$instance;
    }

    // 调用实际类的方法
    public static function __callStatic($method, $params)
    {
        return call_user_func_array([static::getInstance(), $method], $params);
    }
}