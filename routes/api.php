<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Vacantes\Controllers\VacanteController;
use App\Modules\Vacantes\Controllers\PostulationController;
use App\Modules\Vacantes\Controllers\StatsController;

require base_path('app/Modules/Autenticacion/rutas.php');
require base_path('app/Modules/Usuarios/rutas.php');
require base_path('app/Modules/Documentos/rutas.php');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

    // RUTAS DE VACANTES
    Route::prefix('vacantes')->group(function () {
    
    // ESTADÍSTICAS 
    Route::get('/my-stats', [StatsController::class, 'myStats']);
    Route::get('/stats/global', [StatsController::class, 'globalStats']);
    Route::get('/stats/dashboard', [StatsController::class, 'dashboard']);
    Route::get('/stats/report', [StatsController::class, 'report']);
    Route::get('/stats/company/{companyId}', [StatsController::class, 'companyStats']);
    
    // Búsqueda avanzada
    Route::get('/busqueda/avanzada', [VacanteController::class, 'busquedaAvanzada']);
    Route::post('/', [VacanteController::class, 'store']);
    Route::get('/', [VacanteController::class, 'index']);
    Route::get('/{id}', [VacanteController::class, 'show']);
    Route::put('/{id}', [VacanteController::class, 'update']);
    Route::delete('/{id}', [VacanteController::class, 'destroy']);
    
    // ESPECIALES 
    Route::post('/{id}/solicitar', [VacanteController::class, 'solicitar']);
    Route::patch('/{id}/estado', [VacanteController::class, 'actualizarEstado']);
});

// RUTAS DE POSTULACIONES
    Route::prefix('postulations')->group(function () {
    Route::get('/user/{userId}', [PostulationController::class, 'byUser']);
    Route::get('/vacante/{vacanteId}', [PostulationController::class, 'byVacante']);
    Route::get('/', [PostulationController::class, 'index']);
    Route::get('/{id}', [PostulationController::class, 'show']);
    Route::patch('/{id}/status', [PostulationController::class, 'updateStatus']);
    Route::delete('/{id}', [PostulationController::class, 'destroy']);
});

// RUTAS  Estadísticas personales
Route::prefix('users')->group(function () {
    Route::get('/{userId}/stats', [StatsController::class, 'myStats']);
    Route::get('/{userId}/postulations', [StatsController::class, 'userPostulations']);
});