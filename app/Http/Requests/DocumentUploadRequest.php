<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check(); // y la policy "upload" se evalúa en el Controller
    }

    public function rules(): array
    {
        return [
            'doc_type' => 'required|in:cv,cover_letter,evidence,other',
            'file'     => 'required|file|mimes:pdf|mimetypes:application/pdf|max:5120', // 5 MB
            'application_id' => 'nullable|integer|exists:applications,id',
        ];
    }

    public function messages(): array
    {
        return [
            'file.mimes' => 'Solo se permiten archivos PDF.',
            'file.max'   => 'El archivo excede el tamaño máximo de 5 MB.',
        ];
    }
}
