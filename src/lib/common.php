<?php

if (!function_exists('config')) {
    function config($key = null, $default = null)
    {
        return getenv(strtoupper(preg_replace('/\./', '_', $key))) ?: $default;
    }
}