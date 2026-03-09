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
            'name.ar' => 'sometimes|nullable|string',
            'name.en' => 'sometimes|nullable|string',

            'description' => 'sometimes|nullable|array',
            'description.ar' => 'sometimes|nullable|string',
            'description.en' => 'sometimes|nullable|string',

            'image' => 'sometimes|nullable|image|max:255',
        ];
    }

    public function messages(): array
    {
        return getCustomValidationMessages();
    }
}
