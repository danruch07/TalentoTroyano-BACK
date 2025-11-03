<?php
namespace App\Modules\Autenticacion\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest {
    public function rules(): array {
        return [
            'usName'        => ['required','string','max:120'],
            'usLastName'    => ['required','string','max:120'],
            'expedient'     => ['nullable','string','max:30'],
            'usBirthday'    => ['nullable','date'],
            'usPhoneNumber' => ['nullable','string','max:30'],
            'usEmail'       => ['required','email','max:180','unique:Users,usEmail'],
            'password'      => ['required','string','min:8'], // texto plano para registro
        ];
    }
    public function authorize(): bool { return true; }
}
