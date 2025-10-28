<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:200',
            'email'     => 'required|email:rfc,dns|unique:users,email',
            'phone'     => 'nullable|string|max:30',
            'role'      => 'required|in:student,company',
            'password'  => 'required|string|min:8|confirmed',
        ];
    }
}
