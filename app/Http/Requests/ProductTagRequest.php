<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductTagRequest extends FormRequest
{

    //protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }
    public function input($key = null, $default = null)
    {
        $value = parent::input($key, $default);
        // If a specific key is provided, trim only that value
        if ($key !== null) {
            return is_string($value) ? trim($value) : $value;
        }
        // If no key is provided, trim all values in the input array
        if (is_array($value)) {
            return array_map(function ($item) {
                return is_string($item) ? trim($item) : $item;
            }, $value);
        }

        return $value;
    } 
    public function rules(): array
    {
        $id = $this->route('product') ? $this->route('product')->id : null;
        $rules = [
                    "value" =>'required|string|min:5|max:255|unique:product_tags,value,NULL,id,product_id,' . $id,
        ];
        return $rules;
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
