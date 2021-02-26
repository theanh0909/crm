<?php

namespace App\Http\Requests\Api\Client;

use App\Http\Requests\Api\BaseApiRequest;
use App\Rule\CaptchaRule;

class HandleClientRequest extends BaseApiRequest
{
    public function rules()
    {
        return [
            'client_key'            => 'required',
//            'client_hardware_id'    => 'required',
//            'customer_name'         => 'required',
//            'customer_phone'        => 'required',
//            'customer_email'        => 'required',
//            'customer_address'      => 'required',
//            'product'               => 'required',
            'captcha'               => [new CaptchaRule(), 'required'],
            'province'              => 'max:255',
        ];
    }
}
