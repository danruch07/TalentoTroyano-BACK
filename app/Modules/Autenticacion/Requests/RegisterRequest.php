<?php

namespace App\Modules\Autenticacion\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'usName'        => ['required', 'string', 'max:120'],
            'usLastName'    => ['required', 'string', 'max:120'],
            'expedient'     => ['nullable', 'string', 'max:50'],
            'usBirthday'    => ['nullable', 'date'],
            'usPhoneNumber' => ['nullable', 'string', 'max:30'],
            'usEmail'       => ['required', 'email', 'max:180', 'unique:users,usEmail'],
            'password'      => ['required', 'string', 'min:8'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

