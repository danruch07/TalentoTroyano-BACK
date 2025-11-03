<?php
namespace App\Modules\Usuarios\Controllers;

use App\Http\Controllers\Controller;
use App\Soporte\RespuestaApi;
use Illuminate\Http\Request;
use App\Modules\Usuarios\Requests\UpdateProfileRequest;
use App\Modules\Usuarios\Resources\UsuarioResource;

class ProfileController extends Controller {
    use RespuestaApi;

    public function show(Request $request) {
        return $this->ok(new UsuarioResource($request->user()));
    }

    public function update(UpdateProfileRequest $request) {
        $u = $request->user();
        $u->fill($request->validated())->save();
        return $this->ok(new UsuarioResource($u), 'Perfil actualizado');
    }
}
