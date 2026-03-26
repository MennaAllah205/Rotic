<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogUpdateRequest extends FormRequest
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
            'category_id' => 'sometimes|nullable|exists:categories,id',
            'title'       => 'sometimes|nullable',
            'content'     => 'sometimes|nullable',
            'image'       => 'sometimes|nullable|image|max:2048',
            'slug'        => 'sometimes|nullable|string|unique:blogs,slug,' . $this->route('blog'),

            'meta'        => 'sometimes|nullable',
        ];
    }
}
