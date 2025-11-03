<?php
namespace App\Modules\Documentos\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentoResource extends JsonResource {
    public function toArray($request) {
        return [
            'idDocument' => $this->idDocument,
            'idUser'     => $this->idUser,
            'docRoute'   => $this->docRoute,
            'modDate'    => $this->modDate,
            'createdAt'  => $this->created_at,
        ];
    }
}
