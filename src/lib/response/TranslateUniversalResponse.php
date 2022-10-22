<?php

namespace Yufu\Baidu\lib\response;

/**
 * @property-read string from
 * @property-read string to
 * @property-read TransResult[] trans_result
 * @property-read string error_code
 * @property-read string error_msg
 */
class TranslateUniversalResponse extends BaseResponse
{
}

/**
 * @property-read string src
 * @property-read string dst
 */
class TransResult
{
}