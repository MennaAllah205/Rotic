<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required|array',
            'name.ar' => 'required|string',
            'name.en' => 'required|string',

            'description' => 'sometimes|nullable|array',
            'description.ar' => 'sometimes|nullable|string',
            'description.en' => 'sometimes|nullable|string',

            'image' => 'nullable|image|max:255',
        ];
    }

    public function messages(): array
    {
        return getCustomValidationMessages();
    }
}
