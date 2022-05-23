<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ShortUrl
 * @property string $key
 * @property string $short_url
 * @property string $long_url
 * @property Carbon $expire_time
 * @property Carbon|null $deleted_at
 * @package App\Models
 */
class ShortUrl extends Model
{
    protected $fillable = [
        'key',
        'long_url',
        'expire_time',
    ];

    protected $dates = [
        'expire_time',
        'deleted_at',
    ];

    public static function findByKey($key)
    {
        return self::query()->where('key', $key)->first();
    }

    public static function deleteByKey($key)
    {
        return self::query()->where('key', $key)->delete();
    }
}
