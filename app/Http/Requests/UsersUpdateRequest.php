<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersUpdateRequest extends FormRequest
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
        $user = $this->route('user');
        $userId = $user instanceof \App\Models\User ? $user->id : $user;

        return [
            'name' => ['sometimes', 'string', 'max:255'],

            'email' => [
                'sometimes',
                'email'.$this->route('id'),

            ],

            'phone' => [
                'sometimes',
                'string',
                'max:20'
                .$this->route('id'),
            ],

            'password' => [
                'sometimes',
                'string',
                'min:6',
                'confirmed',
            ],

            'roles' => 'sometimes|array',
            'roles.*' => 'exists:roles,id',
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
