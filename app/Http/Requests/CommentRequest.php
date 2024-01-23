<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'comment' => 'string|max:255',
        ];
    }
}
