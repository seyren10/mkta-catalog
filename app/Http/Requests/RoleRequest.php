<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
                "title" => "required|min:5|unique:roles,title", 
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Title is required.',
            'title.min' => 'Title should be 5 characters and above.',
            'title.unique' => 'Title is already registered, it should be unique.'
        ];
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
