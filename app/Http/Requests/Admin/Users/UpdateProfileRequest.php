<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UpdateProfileRequest extends FormRequest
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

        $rules = [
            'name'                  => 'required|max:255|regex:/^\S*$/u|unique:users,name,' . $this->id,
            'fullname'              => 'required|max:255',
            'email'                 => 'email|required|max:255|unique:users,email,' . $this->id,
        ];

        if( (isset($this->old_password) && $this->old_password != '') || (isset($this->password) && $this->password != '') ) {
            $rules['old_password']      = 'required|check_password';
            $rules['password']          = 'required|max:255|min:4';
            $rules['password_confirm']  = 'required|same:password';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'old_password.check_password' => 'The old password is not correct'
        ];
    }
}
