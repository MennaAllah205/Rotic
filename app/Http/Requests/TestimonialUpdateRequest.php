<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialUpdateRequest extends FormRequest
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
            'client_name' => 'sometimes|nullable|max:255|array',
            'title'       => 'sometimes|nullable|max:255|array',
            'body'        => 'sometimes|nullable|max:2000|array',
            'meta'        => 'sometimes|nullable|array',
            'logo'        => 'sometimes|nullable|image|max:2048',

        ];
    }

    public function messages(): array
    {
        return getCustomValidationMessages();
    }
}
