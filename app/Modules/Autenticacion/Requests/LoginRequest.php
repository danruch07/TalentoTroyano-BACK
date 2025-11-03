<?php
namespace App\Modules\Autenticacion\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest {
    public function rules(): array {
        return [
            'usEmail'  => ['required','email'],
            'password' => ['required','string'],
        ];
    }
    public function authorize(): bool { return true; }
}
