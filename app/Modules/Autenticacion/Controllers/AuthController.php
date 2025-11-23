<?php
namespace App\Modules\Autenticacion\Controllers;

use App\Http\Controllers\Controller;
use App\Soporte\RespuestaApi;
use App\Modules\Autenticacion\Requests\RegisterRequest;
use App\Modules\Autenticacion\Requests\LoginRequest;
use App\Modules\Autenticacion\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller {
    use RespuestaApi;

    public function __construct(private AuthService $service) {}

    public function register(RegisterRequest $req) {
        $dto = $this->service->register($req->validated());
        return $this->created($dto, 'User registered');
    }

    public function login(LoginRequest $req) {
        $dto = $this->service->login($req->validated());
        return $this->ok($dto, 'Authenticated');
    }

    public function logout(Request $request) {
        $request->user()?->currentAccessToken()?->delete();
        return $this->noContent();
    }
}