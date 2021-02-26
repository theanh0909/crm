<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'password'              => 'required|max:255|min:4',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
