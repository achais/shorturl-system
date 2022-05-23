<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ReqLog
 * @property string $key
 * @property Carbon $requestTime
 * @property string $ip
 * @package App\Models
 */
class ReqLog extends Model
{
    protected $fillable = [
        'key',
        'request_time',
        'ip',
    ];

    protected $dates = [
        'request_time',
    ];
}
