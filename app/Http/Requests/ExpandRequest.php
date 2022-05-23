<?php

namespace App\Http\Requests;

/**
 * Class ExpandRequest
 * @property string $short_url
 * @package App\Http\Requests
 */
class ExpandRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'short_url' => 'required|string',
        ];
    }
}
