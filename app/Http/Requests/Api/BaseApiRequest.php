<?php

namespace App\Http\Requests\Api;

use App\Exceptions\ValidationErrorExcerption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BaseApiRequest extends FormRequest
{

    protected function failedValidation(Validator $validator)
    {
        $transformed = [];

        $errors = $validator->errors();


        foreach ($errors->keys() as $key) {
            $transformed[] = [
                'name'    => $key,
                'message' => $errors->get($key, [])[0],
            ];
        }

        throw new ValidationErrorExcerption($transformed);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    public function messages()
    {
        return [];
    }

    public function onlyExists($keys)
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        $results = [];

        foreach ($keys as $key) {
            if ($this->has($key)) {
                $results[$key] = $this->get($key);
            }
        }

        return $results;
    }
}
