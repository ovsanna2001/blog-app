<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogTagCreateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'blog_id' => 'required|exists:blogs,id',
            'tag_id' => 'required|exists:tags,id',
        ];
    }

    public function messages()
    {
        return [
            'blog_id.required' => 'A blog ID is required',
            'blog_id.exists' => 'The selected blog ID is invalid',
            'tag_id.required' => 'A tag ID is required',
            'tag_id.exists' => 'The selected tag ID is invalid'
        ];
    }
}
