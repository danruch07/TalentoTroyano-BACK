<?php

namespace App\Modules\Vacantes\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVacanteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'idModality' => 'sometimes|integer',
            'idState' => 'sometimes|integer',
            'idPrograms' => 'sometimes|integer',
            'idAdmin' => 'nullable|integer',
            'idCompany' => 'sometimes|integer',
            'title' => 'sometimes|string|max:150',
            'description' => 'sometimes|string',
            'requirements' => 'sometimes|string',
            'location' => 'sometimes|string|max:150',
            'typeContract' => 'sometimes|string|max:100',
            'salary' => 'sometimes|numeric|min:0',
            'schedule' => 'sometimes|string|max:100',
            'vacDate' => 'sometimes|date'
        ];
    }
}