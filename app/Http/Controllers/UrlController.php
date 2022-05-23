<?php

namespace App\Http\Controllers;

use App\Api\CommonResult;
use App\Events\UrlDeleted;
use App\Events\UrlGenerated;
use App\Events\UrlRequested;
use App\Exceptions\Asserts;
use App\Handlers\IncrementHandler;
use App\Handlers\MurmurHandler;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\ExpandRequest;
use App\Http\Requests\ShortEnRequest;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Cache;

class UrlController extends Controller
{
    protected function prepareKey($longUrl, $rule = 'murmur')
    {
        if ($rule == 'md5') {
            return md5($longUrl);
        }

        //哈希算法
        if ($rule == 'murmur') {
            return MurmurHandler::generate($longUrl);
        }

        //自增序列算法
        if ($rule == 'inc') {
            return IncrementHandler::generate($longUrl);
        }

        Asserts::fail('短链生成规则有误!');
        return '';
    }

    protected function prepareShortUrl($key = '')
    {
        return config('app.url') . '/k/' . $key;
    }

    public function shorten(ShortEnRequest $request)
    {
        //长链转 Key
        $key = $this->prepareKey($request->long_url);
        //准备短链
        $shortUrl = $this->prepareShortUrl($key);
        //过期时间
        $expireTime = now()->addDays($request->day);
        //加缓存
        Cache::put($key, $request->long_url, $expireTime);
        //短链生成事件(永久存储)
        event(new UrlGenerated($key, $request->long_url, $expireTime->getTimestamp()));
        //接口返回
        $data = [
            'short_url' => $shortUrl,
            'expire_time' => $expireTime->getTimestamp()
        ];
        return CommonResult::success($data);
    }

    public function expand(ExpandRequest $request)
    {
        //解析key
        $prefix = $this->prepareShortUrl();
        $key = str_replace($prefix, '', $request->short_url);
        //查缓存
        $longUrl = Cache::get($key);
        if (empty($longUrl)) {
            $shortUrl = ShortUrl::findByKey($key);
            if ($shortUrl && $shortUrl->long_url) {
                if (now()->gt($shortUrl->expire_time)) {
                    $shortUrl->delete();
                    return CommonResult::failed('短链已过期');
                } else {
                    //加缓存
                    Cache::put($key, $shortUrl->long_url, $shortUrl->expire_time);
                }
            } else {
                return CommonResult::failed('短链不存在');
            }
            $longUrl = $shortUrl->long_url;
        }
        //接口返回
        $data = [
            'long_url' => $longUrl
        ];
        return CommonResult::success($data);
    }

    public function delete(DeleteRequest $request)
    {
        //解析key
        $prefix = $this->prepareShortUrl();
        $key = str_replace($prefix, '', $request->short_url);
        //删缓存
        Cache::delete($key);
        //删除事件(永久删除)
        event(new UrlDeleted($key));
        return CommonResult::success();
    }

    public function to(Request $request, $key)
    {
        //查缓存
        $longUrl = Cache::get($key);
        if (empty($longUrl)) {
            //查MySQL
            $url = ShortUrl::findByKey($key);
            //不存在或已过期,返回404
            if (!$url || now()->gt($url->expire_time)) {
                return abort(404);
            } else {
                //加缓存
                Cache::put($key, $url->long_url, $url->expire_time);
            }
            $longUrl = $url->long_url;
        }
        //访问时间
        $requestTimestamp = now()->getTimestamp();
        $requestIp = $request->ip();
        //访问事件(统计)
        event(new UrlRequested($key, $requestTimestamp, $requestIp));
        //跳转
        return redirect()->to($longUrl, 302);
    }
}
