<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (auth()->user()) {
            return true;
        }
    }

    public function rules(): array
    {
        return [
            'caption' => 'required|string|max:255',
            'code' => 'required',
            'programming_language' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'caption.required' => 'Caption is required',
            'code.required' => 'Code is required',
            'programming_language.required' => 'Programming language is required',
        ];
    }
}
