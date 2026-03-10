<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogStoreRequest extends FormRequest
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
            'name.ar' => 'required|string',
            'name.en' => 'required|string',
            'title' => 'sometimes|nullable',
            'title.ar' => 'sometimes|nullable|string',
            'title.en' => 'sometimes|nullable|string',
            'content' => 'sometimes|nullable',
            'content.ar' => 'sometimes|nullable|string',
            'content.en' => 'sometimes|nullable|string',
            'image' => 'sometimes|nullable|image',
            'meta_title' => 'sometimes|nullable',
            'meta_title.ar' => 'sometimes|nullable|string',
            'meta_title.en' => 'sometimes|nullable|string',
            'meta_description' => 'sometimes|nullable',
            'meta_description.ar' => 'sometimes|nullable|string',
            'meta_description.en' => 'sometimes|nullable|string',
        ];
    }
}
