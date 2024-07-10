<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to access this form request
    }

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
