<?php

namespace App\Modules\Vacantes\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostulationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->idPostulation,
            'status' => $this->status,
            'postDate' => $this->postDate,
            'vacante' => $this->idVacant,
            'vacanteTitle' => $this->vacante->title ?? null,
            'user' => $this->idUser,
            'state' => $this->idState,
            'company' => $this->idCompany,
        ];
    }
}