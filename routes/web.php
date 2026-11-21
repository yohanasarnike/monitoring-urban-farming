<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\TanamanController;
use App\Http\Controllers\DashboardSistem;

// Redirect utama ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// Dashboard pengguna
Route::get('/dashboard', [TanamanController::class, 'index'])
    ->name('dashboard');

Route::get('/dashboard.sistem', [DashboardSistem::class, 'index'])
    ->name('dashboard.sistem');

// Notifikasi
Route::get('/notifications', function () {
    return view('notifications');
})->name('notifications');

Route::get('/notifikasi', function () {
    return view('notifications');
});

// Konsultasi
Route::get('/konsultasi', function () {
    return view('konsultasi.welcome');
})->name('konsultasi.welcome');

Route::get('/konsultasi/chat', [ConsultationController::class, 'index'])
    ->name('konsultasi.chat');

Route::post('/konsultasi/send', [ConsultationController::class, 'store'])
    ->name('konsultasi.send');

// Tanaman dan jadwal perawatan
Route::get('/tanaman/tambah', [TanamanController::class, 'create'])
    ->name('tanaman.create');

Route::post('/tanaman/tambah', [TanamanController::class, 'store'])
    ->name('tanaman.store');

Route::get('/jadwal-perawatan', [TanamanController::class, 'jadwalIndex'])
    ->name('jadwal.index');

Route::post('/perawatan/update/{id}', [TanamanController::class, 'updatePerawatan'])
    ->name('perawatan.update');

// Forgot Password
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])
    ->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
    ->name('password.email');

// Reset Password
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])
    ->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->name('password.update');

// Dashboard dan Monitoring Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/monitoring', [AdminController::class, 'monitoring'])
        ->name('admin.monitoring');

    Route::get('/monitoring/{id}', [AdminController::class, 'tanaman'])
        ->name('admin.monitoring.tanaman');

    Route::get('/monitoring/detail/{id}', [AdminController::class, 'detailMonitoring'])
        ->name('admin.monitoring.detail');

    Route::put(
        '/admin/perawatan/{id}/update-catatan',
        [AdminController::class, 'updateKondisiCatatan']
    )->name('admin.perawatan.update');
});
