<?php

namespace App\Exceptions;

use App\Api\ResultCode;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        ApiException::class,
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    //深入处理这一块
    public function render($request, Exception $exception)
    {
        //如果是 API 接口, 自定义异常处理
        if (!($exception instanceof ApiException) && Str::startsWith($request->path(), ['api', 'admin'])) {
            $exception = $this->customPrepareApiException($exception);
        }

        return parent::render($request, $exception);
    }

    //准备好自己要处理的异常
    protected function customPrepareApiException(Exception $e)
    {
        if ($e instanceof AuthenticationException) {
            $e = new ApiException(ResultCode::enum(ResultCode::UNAUTHORIZED)); //未授权
        } elseif ($e instanceof ValidationException) {
            $errors = $e->errors();
            foreach ($errors as $error) {
                $message = \Arr::first($error);
                $e = new ApiException($message);
                break;
            }
            //$e = new ApiException(ResultCode::enum(ResultCode::VALIDATE_FAILED)); //验证错误
        } elseif ($e instanceof NotFoundHttpException) {
            $e = new ApiException(ResultCode::enum(ResultCode::NOT_FOUND)); //404错误
        } elseif ($e instanceof MethodNotAllowedHttpException) {
            $e = new ApiException(ResultCode::enum(ResultCode::METHOD_NOT_ALLOWED)); //请求方式错误
        } elseif ($e instanceof ModelNotFoundException) {
            $e = new ApiException(ResultCode::enum(ResultCode::SYSTEM_ERROR)); //系统错误
        } else {
            \Log::error($e);
            $e = new ApiException(ResultCode::enum(ResultCode::SYSTEM_ERROR)); //系统错误
        }

        return $e;
    }
}
