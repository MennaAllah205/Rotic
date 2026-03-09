<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [

            'name' => 'required|string|max:255',
            'phone' => 'required_without:email|nullable|string|max:20',
            'email' => 'required_without:phone|nullable|email|max:255',
            'title' => 'required_without:body|nullable|string|max:255',
            'body' => 'required_without:title|nullable|string',

        ];

    }

    public function messages(): array
    {
        return getCustomValidationMessages();
    }
}
