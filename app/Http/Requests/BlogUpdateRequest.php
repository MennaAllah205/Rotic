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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'       => 'sometimes|required',
            'name.ar'    => 'sometimes|required|string',
            'name.en'    => 'sometimes|required|string',
            'title'      => 'sometimes|nullable',
            'title.ar'   => 'sometimes|nullable|string',
            'title.en'   => 'sometimes|nullable|string',
            'content'    => 'sometimes|nullable',
            'content.ar' => 'sometimes|nullable|string',
            'content.en' => 'sometimes|nullable|string',
            'image'      => 'sometimes|nullable|image',

            'meta'       => 'sometimes|nullable',
            'meta.ar'    => 'sometimes|nullable|string',
            'meta.en'    => 'sometimes|nullable|string',
        ];
    }
}
