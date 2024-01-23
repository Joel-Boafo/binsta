<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'current_password' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => 'Current password is required',
            'password.required' => 'New password is required',
            'confirm_password.required' => 'Confirm password is required',
            'confirm_password.same' => 'Confirm password does not match',
        ];
    }
}
