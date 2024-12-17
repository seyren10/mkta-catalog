<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'info' => 'required|array',
            'info.id' => 'required|integer',
            'info.parent_code' => 'required|string',
            'info.title' => 'required|string|max:255',
            'info.description' => 'required|string|max:1000',
            'info.volume' => 'required|numeric',
            'info.weight_net' => 'required|numeric',
            'info.weight_gross' => 'required|numeric',
            'info.dimension_length' => 'required|numeric',
            'info.dimension_width' => 'required|numeric',
            'info.dimension_height' => 'required|numeric',
            'category' => 'required|array|min:1',
            'category.*' => 'required|string',
            'images' => 'required|array|min:1',
            'images.*.id' => 'required|integer',
            'images.*.title' => 'required|string',
            'images.*.filename' => 'required|string',
            'images.*.type' => 'required|string',
            'images.*.deleted_at' => 'nullable',
            "restrictionAndExcemption" => 'nullable',
            "related" => 'nullable',
            "recommended" => "nullable"
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
