<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => [
                'bail',
                'required',
                'string',
            ],
            'parent_id' => [
                'bail',
                'nullable',
                'exists:comments,id',
            ],
        ];
    }
}
