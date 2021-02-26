<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'          => 'required|max:255|unique:product,name,' . $this->product,
            'price'         => 'required|numeric',
//            'icon'          => 'image',
            'description'   => 'max:500',
            'version'       => 'max:255',
            'key_version'   => 'max:255',
            'product_type'  => 'required',
        ];
    }
}
