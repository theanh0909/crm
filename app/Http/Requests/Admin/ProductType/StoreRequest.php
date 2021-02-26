<?php

namespace App\Http\Requests\Admin\ProductType;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'          => 'required|max:255',
        ];
    }
}
