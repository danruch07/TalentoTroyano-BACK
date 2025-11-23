<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['API Talento Troyano jalando']);
});

// Cualquier otra ruta web no definida → 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
