<?php
namespace App\Modules\Documentos\Policies;

use App\Modules\Usuarios\Models\Usuario;
use App\Modules\Documentos\Models\Documento;

class DocumentoPolicy {
    // Sólo el propietario puede ver/descargar su documento
    public function view(Usuario $u, Documento $d): bool {
        return $d->idUser === $u->idUser;
    }
}
