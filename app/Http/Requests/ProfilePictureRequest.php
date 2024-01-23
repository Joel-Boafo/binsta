<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilePictureRequest extends FormRequest
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
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
