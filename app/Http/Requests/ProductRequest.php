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
                    "id" =>'required|string|max:255|unique:products,id',
                    "title" =>'required|string|max:255|unique:products,title',
        ];
        if($this->getMethod() ==  'PUT'){
            $rules = [
                // "id" => [
                //     'required',
                //     'string',
                //     'max:255',
                //     Rule::unique('products','id')->ignore($id),
                // ],
                "title" => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('products','id')->ignore($id),
                ],
            ];
        }
        return $rules;
    }
    public function all($keys = null)
    {
        $data = parent::all($keys);
        if( $this->getMethod() != 'PUT'){
            $data["volume"] = trim($data["volume"]) ?? 0.0;
            $data["weight_net"] = trim($data["weight_net"]) ?? 0.0;
            $data["weight_gross"] = trim($data["weight_gross"]) ?? 0.0;
            $data["dimension_length"] = trim($data["dimension_length"]) ?? 0.0;
            $data["dimension_width"] = trim($data["dimension_width"]) ?? 0.0;
            $data["dimension_height"] = trim($data["dimension_height"]) ?? 0.0;
        }
        return $data;
    }
    public function messages()
    {
        return [
            'id.unique' => "The Product ID has already been taken."
        ];
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
