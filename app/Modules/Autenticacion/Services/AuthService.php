<?php

namespace App\Modules\Autenticacion\Services;

use App\Modules\Usuarios\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data): array
    {
        $usuario = Usuario::create([
            'usName'        => $data['usName'],
            'usLastName'    => $data['usLastName'],
            'expedient'     => $data['expedient'] ?? null,
            'usBirthday'    => $data['usBirthday'] ?? null,
            'usPhoneNumber' => $data['usPhoneNumber'] ?? null,
            'usEmail'       => $data['usEmail'],
            'usPassword'    => Hash::make($data['password']),
        ]);

        $token = $usuario->createToken('api')->plainTextToken;

        return [
            'user'  => $this->userPayload($usuario),
            'token' => $token,
        ];
    }

    public function login(array $data): array
    {
        $usuario = Usuario::where('usEmail', $data['usEmail'])->first();

        if (!$usuario || !Hash::check($data['password'], $usuario->usPassword)) {
            abort(401, 'Invalid credentials');
        }

        $token = $usuario->createToken('api')->plainTextToken;

        return [
            'user'  => $this->userPayload($usuario),
            'token' => $token,
        ];
    }

    private function userPayload(Usuario $u): array
    {
        return [
            'idUser'          => $u->idUser,
            'usName'          => $u->usName,
            'usLastName'      => $u->usLastName,
            'expedient'       => $u->expedient,
            'usBirthday'      => $u->usBirthday,
            'usPhoneNumber'   => $u->usPhoneNumber,
            'usEmail'         => $u->usEmail,
            'usProfilePicture'=> $u->usProfilePicture,
            'createdAt'       => $u->created_at,
        ];
    }
}

