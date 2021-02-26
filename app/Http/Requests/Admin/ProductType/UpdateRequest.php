<?php

namespace App\Http\Requests\Admin\ProductType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'          => 'required|max:255',
        ];
    }
}
