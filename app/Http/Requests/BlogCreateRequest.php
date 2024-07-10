<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to access this form request
    }

    public function rules()
    {
        return [
            'image' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'The image field is required.',
            'title.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
        ];
    }
}
