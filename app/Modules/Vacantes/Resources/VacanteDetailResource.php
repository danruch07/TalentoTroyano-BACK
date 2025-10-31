<?php

namespace App\Modules\Vacantes\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VacanteDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->idVacant,
            'title' => $this->title,
            'description' => $this->description,
            'requirements' => $this->requirements,
            'location' => $this->location,
            'typeContract' => $this->typeContract,
            'salary' => (float) $this->salary,
            'schedule' => $this->schedule,
            'vacDate' => $this->vacDate->format('d-m-y'),
            'modality' => $this->idModality,
            'state' => $this->idState,
            'company' => $this->idCompany,
            'program' => $this->idPrograms,
        ];
    }
}