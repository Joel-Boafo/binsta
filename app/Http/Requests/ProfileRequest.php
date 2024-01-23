<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => 'required|string|max:255' . auth()->user()->id,
            'username' => 'required|string|max:255|regex:/^[a-zA-Z0-9_.-]+$/u|unique:users,username,' . auth()->user()->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->user()->id,
            'bio' => 'nullable|string|max:255',
            'customGender' => 'nullable|string|max:40',
        ];
    }

    public function messages()
    {
        return [
            'username.regex' => 'Username can only contain letters, numbers, dashes, dots and underscores',
        ];
    }
}
