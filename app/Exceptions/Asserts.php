<?php

namespace App\Exceptions;

use App\Api\IErrorCode;
use App\Api\ResultCode;

class Asserts
{
    public static function fail($message)
    {
        if (is_int($message)) {
            $message = ResultCode::enum($message);
        }
        throw new ApiException($message);
    }
}
