<?php

namespace App\Http\Requests\Backend\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email'     => 'required|unique:users,email|email|max:255',
            'password'  => 'required|min:4|max:200',
        ];
    }
}
