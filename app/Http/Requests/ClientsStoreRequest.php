<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientsStoreRequest extends FormRequest
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

            'name' => 'required',

            'description' => 'sometimes|nullable',
            'link' => 'sometimes|nullable|url',
            'logo' => 'sometimes|nullable|image',
            'meta' => 'sometimes|nullable|array',
            'keywords' => 'sometimes|nullable|array',
            'roles' => 'sometimes|array',
            'roles.*' => 'exists:roles,id',

        ];
    }

    public function messages(): array
    {
        return getCustomValidationMessages();
    }
}
