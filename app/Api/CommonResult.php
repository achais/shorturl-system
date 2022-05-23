<?php

namespace App\Api;

use Illuminate\Contracts\Support\Arrayable;

class CommonResult implements Arrayable
{
    private $code;
    private $message;
    private $data;

    public function __construct(int $code, string $message, $data)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    public static function success($data = null)
    {
        if (is_string($data)) {
            return self::successIncludeDataAndMessage(null, $data);
        } else {
            return self::successIncludeData($data);
        }
    }

    public static function successIncludeData($data)
    {
        if ($data instanceof Arrayable) $data = $data->toArray();
        $resultCode = ResultCode::enum(ResultCode::SUCCESS);
        return new CommonResult($resultCode->getCode(), $resultCode->getMessage(), $data);
    }

    public static function successIncludeDataAndMessage($data, string $message)
    {
        if ($data instanceof Arrayable) $data = $data->toArray();
        $resultCode = ResultCode::enum(ResultCode::SUCCESS);
        return new CommonResult($resultCode->getCode(), $message, $data);
    }

    public static function failed($message = '')
    {
        return self::failedIncludeMessage($message);
    }

    public static function failedIncludeMessage(string $message)
    {
        $errorCode = ResultCode::enum(ResultCode::FAILED);
        if (empty($message)) $message = $errorCode->getMessage();
        return new CommonResult($errorCode->getCode(), $message, null);
    }

    public static function failedIncludeErrorCode($errorCode)
    {
        if (is_int($errorCode)) {
            $errorCode = ResultCode::enum($errorCode);
        }
        return new CommonResult($errorCode->getCode(), $errorCode->getMessage(), null);
    }

    public static function failedIncludeErrorCodeAndMessage($errorCode, string $message)
    {
        if (is_int($errorCode)) {
            $errorCode = ResultCode::enum($errorCode);
        }
        return new CommonResult($errorCode->getCode(), $message, null);
    }

    public static function validateFailed()
    {
        return self::failedIncludeErrorCode(ResultCode::VALIDATE_FAILED);
    }

    public static function validateFailedIncludeMessage(string $message)
    {
        return self::failedIncludeErrorCodeAndMessage(ResultCode::VALIDATE_FAILED, $message);
    }

    public static function unauthorized()
    {
        return self::failedIncludeErrorCode(ResultCode::UNAUTHORIZED);
    }

    public static function forbidden()
    {
        return self::failedIncludeErrorCode(ResultCode::FORBIDDEN);
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getData()
    {
        return $this->data;
    }

    public function toArray()
    {
        return [
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
            'data' => $this->getData(),
        ];
    }
}
