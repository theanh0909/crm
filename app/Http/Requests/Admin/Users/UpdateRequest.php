<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'name'                  => 'required|max:255|regex:/^\S*$/u|unique:users,name,' . $this->user,
            'fullname'              => 'required|max:255',
            'email'                 => 'email|required|max:255|unique:users,name,' . $this->user,
        ];

        if( isset($this->password) && $this->password != '' ) {
            $rules['password']          = 'required|max:255|min:4';
            $rules['password_confirm']  = 'required|same:password';
        }

        return $rules;
    }
}
