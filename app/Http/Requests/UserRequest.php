<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // //protected $stopOnFirstFailure = true;
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
        $id = $this->route('user') ? $this->route('user')->id : null;
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($id)
            ],
        ];
        if ($this->getMethod() ==  'PUT') {
            $rules = [
                'password' => [
                    'required',
                    'min:8',
                    'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*_?&])[A-Za-z\d@$!%*_?&]+$/',
                ]
            ];
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.regex' => "Password should contain at least 1 Letter, 1 Number, 1 Special Characters( @ $ ! % * ? & _ ) and should not contain spaces"
        ];
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
