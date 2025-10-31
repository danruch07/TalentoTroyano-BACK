<?php

namespace App\Modules\Vacantes\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VacanteListResource extends JsonResource
{
    // Datos para el sidebar
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->idVacant,
            'title' => $this->title,
            'company' => $this->idCompany,
            'companyName' => $this->company->name ?? 'Empresa', 
            'salary' => (float) $this->salary,
            'location' => $this->location,
            'vacDate' => $this->vacDate->format('d-m-y'),
        ];
    }
}