<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Usuarios\Controllers\ProfileController;

Route::middleware(['auth:sanctum','json'])->group(function () {
    Route::get('/me', [ProfileController::class, 'show']);
    Route::put('/me', [ProfileController::class, 'update']);
});
