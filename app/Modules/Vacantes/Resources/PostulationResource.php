<?php

namespace App\Modules\Vacantes\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostulationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = $this->whenLoaded('user');

        // CV: último documento del alumno (si está cargado y relación existe)
        $cv = null;
        if ($user && method_exists($user, 'documentos')) {
            $doc = $user->documentos()->orderByDesc('modDate')->first();
            if ($doc) {
                $cv = [
                    'idDocument' => $doc->idDocument,
                    'docRoute'   => $doc->docRoute,
                    'modDate'    => $doc->modDate,
                ];
            }
        }

        return [
            'id'        => $this->idPostulation,
            'status'    => $this->status,
            'postDate'  => $this->postDate,
            'vacante'   => $this->idVacant,
            'vacanteTitle' => $this->vacante->title ?? null,

            // Datos crudos
            'idUser'    => $this->idUser,
            'idState'   => $this->idState,
            'idCompany' => $this->idCompany,

            // Datos del alumno (para "ver postulantes de una vacante")
            'student' => $user ? [
                'idUser'          => $user->idUser,
                'name'            => $user->usName,
                'lastName'        => $user->usLastName,
                'expedient'       => $user->expedient,
                'profilePicture'  => $user->usProfilePicture,
            ] : null,

            // Carrera (si program está cargado)
            'program' => $this->whenLoaded('program', function () {
                return [
                    'idPrograms' => $this->program->idPrograms ?? null,
                    'prName'     => $this->program->prName ?? null,
                ];
            }),

            // CV (puede ser null)
            'cv' => $cv,
        ];
    }
}

