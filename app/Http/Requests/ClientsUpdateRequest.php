<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientsUpdateRequest extends FormRequest
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

            'name' => 'sometimes|required',

            'description' => 'sometimes|nullable',

            'link' => 'sometimes|nullable|url',
            'logo' => 'sometimes|nullable|image|max:2048',

            'meta' => 'sometimes|nullable|array',
            'keywords' => 'sometimes|nullable|array',

        ];
    }

    public function messages(): array
    {
        return getCustomValidationMessages();
    }
}
