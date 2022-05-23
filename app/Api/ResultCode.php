<?php

namespace App\Api;

use RuntimeException;

class ResultCode implements IErrorCode
{
    private $code;
    private $message;

    const FAILED = -1;
    const SUCCESS = 0;
    const UNAUTHORIZED = 401;
    const IP_WHITELIST_NOT_ALLOWED = 402;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const VALIDATE_FAILED = 423;
    const SYSTEM_ERROR = 500;
    const UNKNOWN_ERROR = 501;

    private static $enumMap = [
        self::FAILED => '操作失败',
        self::SUCCESS => '操作成功',
        self::UNAUTHORIZED => '请先登录',
        self::IP_WHITELIST_NOT_ALLOWED => '不在IP白名单内',
        self::FORBIDDEN => '暂无权限',
        self::NOT_FOUND => '未找到页面',
        self::METHOD_NOT_ALLOWED => '请求方式不允许',
        self::VALIDATE_FAILED => '参数验证失败',
        self::SYSTEM_ERROR => '系统错误',
        self::UNKNOWN_ERROR => '未知错误',
    ];

    public function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    public static function enum($code)
    {
        if (array_key_exists($code, self::$enumMap)) {
            return new self($code, self::$enumMap[$code]);
        }
        throw new RuntimeException("ResultCode无效");
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
