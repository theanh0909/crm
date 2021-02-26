<?php

namespace App\Http\Requests\Admin\License;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status'                    => 'required',
            'product_type'              => 'required',
            'type_expire_date'          => 'required',
            'no_keys'                   => 'required',
            'license_no_computers'      => 'required',
            'license_no_instance'       => 'required',
            'id_user'                   => 'required'
        ];
    }
}
