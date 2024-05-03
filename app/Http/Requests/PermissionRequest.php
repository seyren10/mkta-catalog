<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class PermissionRequest extends FormRequest
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
        $id = $this->route('permission') ? $this->route('permission')->id : null;
        return [
            "title" =>[
                'required',
                'string',
                'min:5',
                Rule::unique('permissions','title')->ignore($id)
            ],
            "key" => [
                'required',
                'string',
                'min:5',
                Rule::unique('permissions','key')->ignore($id)
            ]
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Permission Title is required.',
            'title.min' => 'Permission Title should be :min characters and above.',
            'title.unique' => 'Permission Title is already registered, it should be unique.',

            'key.required' => 'Permission Key is required.',
            'key.min' => 'Permission Key should be :min characters and above.',
            'key.unique' => 'Permission Key is already registered, it should be unique.',

        ];
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
