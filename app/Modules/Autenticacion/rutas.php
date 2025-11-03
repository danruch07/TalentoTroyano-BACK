<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Autenticacion\Controllers\AuthController;

Route::prefix('auth')->middleware('json')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
    Route::post('/logout',   [AuthController::class, 'logout'])->middleware('auth:sanctum');
});
