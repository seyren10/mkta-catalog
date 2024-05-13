<?php

namespace App\Http\Requests;

use App\Models\AreaCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AreaCodeRequest extends FormRequest
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
    protected function prepareForValidation()
    {
        $this->merge([
            'name' => trim($this->name),
            'description' => trim($this->description),
        ]);
    }
    protected function passedValidation()
    {
        $this->merge([
            'name' => trim($this->name),
            'description' => trim($this->description),
            // Trim other fields as needed
        ]);
    }
    

    public function rules(): array
    {
        $id = in_array($this->getMethod(), ["PUT", "PATCH"]) ? $this->route('area_code')->id : null;
            return [
                "title" => [
                        'required',
                        'string',
                        'min:5',
                        Rule::unique('area_codes','title')->ignore($id),
                    ]
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

    // public function validated()
    // {
    //     $validated = parent::validated();

    //     // Trim the validated data
    //     foreach ($validated as $key => $value) {
    //         $validated[$key] = is_string($value) ? trim($value) : $value;
    //     }

    //     return $validated;
    // }
}
