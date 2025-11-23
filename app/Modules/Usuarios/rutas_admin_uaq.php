<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Usuarios\Controllers\AdminUaqController;

/**
 * Rutas de administración UAQ.
 * Proteger con auth:sanctum + json (cuando ya se implementen roles).
 */

Route::middleware(['auth:sanctum', 'json'])->prefix('admin-uaq')->group(function () {
    // Crear empresa + credenciales temporales
    Route::post('/companies', [AdminUaqController::class, 'createCompany']);

    // Dar de baja alumnos y empresas
    Route::delete('/students/{idUser}', [AdminUaqController::class, 'deactivateStudent']);
    Route::delete('/companies/{idCompany}', [AdminUaqController::class, 'deactivateCompany']);

    // Listas
    Route::get('/students', [AdminUaqController::class, 'listStudents']);
    Route::get('/companies', [AdminUaqController::class, 'listCompanies']);

    // CV alumno
    Route::get('/students/{idUser}/cv', [AdminUaqController::class, 'getStudentCv']);
});

