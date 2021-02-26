<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'                  => 'required|unique:users,name|max:255|regex:/^\S*$/u',
            'fullname'              => 'required|max:255',
            'email'                 => 'email|required|unique:users,name|max:255',
            'password'              => 'required|max:255|min:4',
            'password_confirm'      => 'required|same:password',
        ];
    }
}
