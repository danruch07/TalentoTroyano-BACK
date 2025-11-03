<?php
namespace App\Modules\Usuarios\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest {
    public function rules(): array {
        return [
            'usName'          => ['sometimes','string','max:120'],
            'usLastName'      => ['sometimes','string','max:120'],
            'expedient'       => ['sometimes','nullable','string','max:30'],
            'usBirthday'      => ['sometimes','nullable','date'],
            'usPhoneNumber'   => ['sometimes','nullable','string','max:30'],
            'usProfilePicture'=> ['sometimes','nullable','string','max:255'],
        ];
    }
    public function authorize(): bool { return true; }
}
