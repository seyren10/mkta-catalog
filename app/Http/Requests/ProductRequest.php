<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $id = $this->route('product') ? $this->route('product')->id : null;
        $rules = [
                    "id" =>'required|string|max:255|unique:products,id'
        ];
        if($this->getMethod() ==  'PUT'){
            $rules = [
                "id" => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('products','id')->ignore($id),
                ],
                "title" => "required|string|max:255"
            ];
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'id.required' => 'Product ID is required',
            'id.unique' => 'Product ID is already in use',
        ];
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
