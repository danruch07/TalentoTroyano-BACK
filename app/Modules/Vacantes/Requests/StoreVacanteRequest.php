<?php

namespace App\Modules\Vacantes\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVacanteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'idModality' => 'required|integer',
            'idState' => 'required|integer',
            'idPrograms' => 'required|integer',
            'idAdmin' => 'nullable|integer',
            'idCompany' => 'required|integer',
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'location' => 'required|string|max:150',
            'typeContract' => 'required|string|max:100',
            'salary' => 'required|numeric|min:0',
            'schedule' => 'required|string|max:100',
            'vacDate' => 'required|date|after:today'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio',
            'title.max' => 'El título no puede exceder los 150 caracteres',
            'description.required' => 'La descripción es obligatoria',
            'requirements.required' => 'Los requisitos son obligatorios',
            'location.required' => 'La ubicación es obligatoria',
            'typeContract.required' => 'El tipo de contrato es obligatorio',
            'salary.required' => 'El salario es obligatorio',
            'salary.numeric' => 'El salario debe ser un número',
            'salary.min' => 'El salario debe ser mayor a 0',
            'schedule.required' => 'El horario es obligatorio',
            'vacDate.required' => 'La fecha de la vacante es obligatoria',
            'vacDate.date' => 'La fecha debe ser válida',
            'vacDate.after' => 'La fecha debe ser posterior a hoy',
            'idModality.required' => 'La modalidad es obligatoria',
            'idState.required' => 'El estado es obligatorio',
            'idPrograms.required' => 'El programa es obligatorio',
            'idCompany.required' => 'La empresa es obligatoria',
        ];
    }
}