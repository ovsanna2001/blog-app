<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentUpdateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'content' => 'required|string',
            'blog_id' => 'required|exists:blogs,id',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'The content field is required.',
            'blog_id.required' => 'The blog_id field is required.',
            'blog_id.exists' => 'The selected blog is invalid.',
        ];
    }
}
