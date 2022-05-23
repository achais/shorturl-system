<?php

namespace App\Http\Requests;

/**
 * Class DeleteRequest
 * @property string $short_url
 * @package App\Http\Requests
 */
class DeleteRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'short_url' => 'required|string',
        ];
    }
}
