<?php

namespace App\Exceptions;

use App\Api\CommonResult;
use App\Api\IErrorCode;
use Throwable;

class ApiException extends \RuntimeException
{
    private $errorCode;

    public function __construct($message = "", Throwable $previous = null, $code = 0)
    {
        if ($message instanceof IErrorCode) {
            $this->errorCode = $message;
            parent::__construct($message->getMessage(), $code, $previous);
        } else {
            parent::__construct($message, $code, $previous);
        }
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function render()
    {
        if ($this->getErrorCode() instanceof IErrorCode) {
            return response()->json(CommonResult::failedIncludeErrorCode($this->getErrorCode()));
        } else {
            if ($this->getMessage()) {
                return response()->json(CommonResult::failedIncludeMessage($this->getMessage()));
            } else {
                return response()->json(CommonResult::failed());
            }
        }
    }
}
