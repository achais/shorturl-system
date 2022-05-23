<?php

namespace App\Handlers;

use App\Exceptions\Asserts;
use lastguest\Murmur;

class MurmurHandler
{
    /**
     * Calculate the murmur hash of a string
     * @param $str
     * @return string
     */
    public static function generate($str)
    {
        if (empty($str)) {
            Asserts::fail('Murmur Hash 生成有误!');
        }
        //哈希值
        $num = Murmur::hash3_int($str);
        \Log::info($num);
        //转62进制
        return self::fmt10to62($num);
    }

    protected static function fmt10to62($num) {
        $to = 62;
        $dict = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $ret = '';
        do {
            $ret = $dict[bcmod($num, $to)] . $ret; //取模
            $num = bcdiv($num, $to); //整除
        } while ($num > 0);
        return $ret;
    }
}
