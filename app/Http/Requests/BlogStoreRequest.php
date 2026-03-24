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
            'category_id' => 'required|exists:categories,id',
            'title'       => 'sometimes|nullable',
            'content'     => 'sometimes|nullable',
            'image'       => 'sometimes|nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'slug'        => 'sometimes|nullable|string|unique:blogs,slug',
            'meta'        => 'sometimes|nullable',
        ];
    }
}
