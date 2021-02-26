<?php

namespace App\Http\Requests\Api\Client;

use App\Http\Requests\Api\BaseApiRequest;
use App\Rule\CaptchaRule;

class GetKeyRequest extends BaseApiRequest
{
    public function rules()
    {
        return [
            'quantity'              => 'required',
            'product'               => 'required',
            'key_type'              => 'required',
            'expire_date'           => 'required',
        ];
    }
}
