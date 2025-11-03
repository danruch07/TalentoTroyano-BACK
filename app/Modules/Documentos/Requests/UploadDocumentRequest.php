<?php
namespace App\Modules\Documentos\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadDocumentRequest extends FormRequest {
    public function rules(): array {
        return [ 'file' => ['required','file','mimes:pdf','max:5120'] ];
    }
    public function authorize(): bool { return true; }
}
