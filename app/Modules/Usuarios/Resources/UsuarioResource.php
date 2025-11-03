<?php
namespace App\Modules\Usuarios\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource {
    public function toArray($request) {
        return [
            'idUser'          => $this->idUser,
            'usName'          => $this->usName,
            'usLastName'      => $this->usLastName,
            'expedient'       => $this->expedient,
            'usBirthday'      => $this->usBirthday,
            'usPhoneNumber'   => $this->usPhoneNumber,
            'usEmail'         => $this->usEmail,
            'usProfilePicture'=> $this->usProfilePicture,
            'createdAt'       => $this->created_at,
        ];
    }
}
