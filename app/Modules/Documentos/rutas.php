<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Documentos\Controllers\DocumentoController;

Route::middleware(['auth:sanctum','json'])->group(function () {
    Route::post('/documents', [DocumentoController::class,'store']);
    Route::get('/documents/{documento}', [DocumentoController::class,'show']);
    Route::get('/documents/{documento}/download-url', [DocumentoController::class,'downloadUrl']);
});
Route::get('/documents/{documento}/download', [DocumentoController::class,'downloadSigned'])
    ->name('documents.download.signed');
