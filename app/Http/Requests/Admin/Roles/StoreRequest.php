<?php

namespace App\Http\Requests\Admin\Roles;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'          => 'required|unique:roles,name|max:255',
            'display_name'  => 'required|unique:roles,display_name|max:255',
            'permissions'   => 'array',
        ];
    }
}
