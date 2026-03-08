<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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

            'name'         => 'required',
            'name.ar'      => 'required|string',
            'name.en'      => 'required|string',

            'facebook'     => 'sometimes|nullable|url',
            'youtube'      => 'sometimes|nullable|url',
            // 'insta'
            'meta'         => 'sometimes|nullable|array',

            'email'        => 'sometimes|nullable|email',
            'phone'        => 'sometimes|nullable|string',
            'second_phone' => 'sometimes|nullable|string',

            'logo'         => 'sometimes|nullable|image',

        ];
    }

    /**
     * Get the custom validation messages for the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return getCustomValidationMessages();
    }
}
