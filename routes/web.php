<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ConsultationController;
use Illuminate\Support\Facades\Route;

// Redirect utama ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route Notifikasi
Route::get('/notifications', function () {
    return view('notifications');
})->name('notifications');

// Route Konsultasi
Route::get('/konsultasi', function () {
    return view('konsultasi.welcome');
})->name('konsultasi.welcome');

// Route Chat Konsultasi
Route::get('/konsultasi/chat', [ConsultationController::class, 'index'])->name('konsultasi.chat');
Route::post('/konsultasi/chat/send', [ConsultationController::class, 'store'])->name('konsultasi.send');

// Form & Proses Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'validasiLogin'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard-admin', function () {
        return view('dashboard.admin');
    })->name('dashboard.admin');

    Route::get('/dashboard-user', function () {
        return view('dashboard.user');
    })->name('dashboard.user');
});