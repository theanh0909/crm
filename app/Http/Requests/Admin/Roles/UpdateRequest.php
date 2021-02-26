<?php

namespace App\Http\Requests\Admin\Roles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'          => 'required|max:255|unique:roles,name,'. $this->role,
            'display_name'  => 'required|max:255|unique:roles,display_name,' . $this->role,
            'permissions'   => 'array',
        ];
    }
}
