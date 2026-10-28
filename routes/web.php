<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\TanamanController;
use App\Http\Controllers\DashboardSistem;

// Redirect utama ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Autentikasi (Login, Register, Logout)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Utama & Admin
Route::get('/dashboard', [TanamanController::class, 'index'])->name('dashboard');
Route::get('/dashboard.sistem', [DashboardSistem::class, 'index'])->name('dashboard.sistem');

// Notifikasi
Route::get('/notifications', function () {
    return view('notifications');
})->name('notifications');

// Konsultasi
Route::get('/konsultasi', function () {
    return view('konsultasi.welcome');
})->name('konsultasi.welcome');

Route::get('/konsultasi/chat', [ConsultationController::class, 'index'])->name('konsultasi.chat');
Route::post('/konsultasi/send', [ConsultationController::class, 'store'])->name('konsultasi.send');

// Tanaman & Jadwal Perawatan
Route::get('/tanaman/tambah', [TanamanController::class, 'create'])->name('tanaman.create');
Route::post('/tanaman/tambah', [TanamanController::class, 'store'])->name('tanaman.store');
Route::get('/jadwal-perawatan', [TanamanController::class, 'jadwalIndex'])->name('jadwal.index');
Route::post('/perawatan/update/{id}', [TanamanController::class, 'updatePerawatan'])->name('perawatan.update');

//Notifikasi
Route::get('/notifikasi', function () {
    return view('notifications');
});