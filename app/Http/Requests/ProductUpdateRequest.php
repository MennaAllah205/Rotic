<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name' => 'sometimes|nullable|array',

            'description' => 'sometimes|nullable|array',

            'images' => 'sometimes|nullable|array',
            'images.*' => 'image|max:2048',
        ];
    }

    public function messages(): array
    {
        return getCustomValidationMessages();
    }
}
