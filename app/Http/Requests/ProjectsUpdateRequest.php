<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectsUpdateRequest extends FormRequest
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
            'client_id' => 'sometimes|required|exists:clients,id',
            'title' => 'sometimes|required|array',
            'description' => 'sometimes|nullable|array',
            'features' => 'sometimes|nullable|array',
            'link' => 'sometimes|nullable|string|max:255|url',
            'image' => 'sometimes|nullable|image|max:255',
            'meta' => 'sometimes|nullable|array',
            'keywords' => 'sometimes|nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return getCustomValidationMessages();
    }
}
