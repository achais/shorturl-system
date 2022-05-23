<?php

namespace App\Http\Requests;

/**
 * Class ShortEnRequest
 * @property string $long_url
 * @property int $day
 * @package App\Http\Requests
 */
class ShortEnRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'long_url' => 'required|string',
            'day' => 'required|int'
        ];
    }
}
