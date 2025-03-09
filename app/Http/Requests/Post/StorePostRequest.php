<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title' => [
                'bail',
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'bail',
                'nullable',
                'string',
                'max:100',
            ],
            'content' => [
                'bail',
                'string',
            ],
            'image' => [
                'bail',
                'nullable',
                'image',
            ],
            'category_id' => [
                'bail',
                'required',
                'exists:categories,id',
            ],
            'categories' => [
                'bail',
                'nullable',
                'array',
            ],
            'categories.*' => [
                'bail',
                'required',
                'exists:categories,id',
            ],
            'published' => [
                'bail',
                'nullable',
                'boolean',
            ],
        ];
    }
}
