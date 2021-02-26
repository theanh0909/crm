<?php

namespace App\Http\Requests\Admin\License;

use Illuminate\Foundation\Http\FormRequest;

class SendKeyRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email_customer'            => 'required|email',
            'product_type'              => 'required',
            'id_user'                   => 'required',
            'status'                    => 'required',
            'n_key'                     => 'required|digits_between:1,100',
            'type_expire_date'          => 'required',
        ];
    }
}
