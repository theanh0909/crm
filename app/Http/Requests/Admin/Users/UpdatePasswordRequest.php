<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UpdatePasswordRequest extends FormRequest
{
    public function rules()
    {
        Validator::extend('check_password', function($key, $value, $attr) {
            $user = auth()->user();
            if(Hash::check($value, $user->password)) {
                return true;
            }
            return false;
        });

        return [
            'old_password'          => 'required|check_password',
            'password'              => 'required|max:255|min:4',
            'password_confirm'      => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'old_password.check_password' => 'The old password is wrong',
        ];
    }
}
