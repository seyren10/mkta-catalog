<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductAccessTypeRequest extends FormRequest
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
        $id = $this->route('product_access_type') ? $this->route('product_access_type')->id : null;
        return [
                "type" => [
                    'required',
                    'string',
                    'min:5',
                    Rule::unique('product_access_types','type')->ignore($id),
                ],
                "title" => ['required'],

                "ref_type" => ['required'],
                "ref_table" => ['required'],
                "ref_column" => ['required'],
                "source_table" => ['required'],
                "source_column" => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Title is required.',
            'title.min' => 'Title should be :min characters and above.',
            'title.unique' => 'Title is already registered, it should be unique.'
        ];
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
