<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\DocumentController;

// Documentos
Route::middleware('auth')->group(function () {
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/upload', [DocumentController::class, 'form'])->name('documents.form');
    Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
});


// Invitados
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register.perform');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');

    Route::get('/forgot-password', [PasswordController::class, 'showForgot'])->name('password.forgot');
    Route::post('/forgot-password', [PasswordController::class, 'sendLink'])->name('password.email');

    Route::get('/reset-password', [PasswordController::class, 'showReset'])->name('password.reset');
    Route::post('/reset-password', [PasswordController::class, 'reset'])->name('password.update');
});

// Autenticados
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Admin: gestión de usuarios
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users.index');
        Route::post('/users/{user}/promote-company', [UserManagementController::class, 'promoteToCompany'])->name('admin.users.promote_company');
        Route::post('/users/{user}/promote-admin', [UserManagementController::class, 'promoteToAdmin'])->name('admin.users.promote_admin');
        Route::post('/users/{user}/demote-student', [UserManagementController::class, 'demoteToStudent'])->name('admin.users.demote_student');
    });
});
