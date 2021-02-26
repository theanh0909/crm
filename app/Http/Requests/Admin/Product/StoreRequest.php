<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'          => 'required|max:255|unique:product',
            'price'         => 'required|numeric',
//            'icon'          => 'image|mimes:jpeg,png,jpg,gif,svg,ico',
            'description'   => 'max:500',
            'version'       => 'max:255',
            'key_version'   => 'max:255',
            'product_type'  => 'required',
        ];
    }
}
