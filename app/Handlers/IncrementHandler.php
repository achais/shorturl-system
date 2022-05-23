<?php

namespace App\Handlers;

use App\Exceptions\Asserts;

class IncrementHandler
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

        return  md5($str);
    }
}
