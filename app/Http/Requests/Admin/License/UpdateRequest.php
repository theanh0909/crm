<?php

namespace App\Http\Requests\Admin\License;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status'                    => 'required',
            'product_type'              => 'required',
            'type_expire_date'          => 'required',
            'id_user'                   => 'required'
        ];
    }
}
