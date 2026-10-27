<?php

<<<<<<< HEAD
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ConsultationController;
=======
use App\Http\Controllers\TanamanController;
>>>>>>> 0e4d64dca97610822af8f317a9434d7c7f84cfcf
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardSistem;
use App\Http\Controllers\AuthController;

<<<<<<< HEAD
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
=======

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/dashboard.sistem', [DashboardSistem::class, 'index'])
    ->name('dashboard.sistem');

// Halaman login dan proses login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// Halaman register dan proses register
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.submit');

// Proses logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');
    

Route::get('/tanaman/tambah', [TanamanController::class, 'create']);
Route::post('/tanaman/tambah', [TanamanController::class, 'store']);



Route::get('/dashboard', [TanamanController::class, 'index'])->name('dashboard');

Route::get('/jadwal-perawatan', [TanamanController::class, 'jadwalIndex'])->name('jadwal.index');
Route::post('/perawatan/update/{id}', [TanamanController::class, 'updatePerawatan'])->name('perawatan.update');
>>>>>>> 0e4d64dca97610822af8f317a9434d7c7f84cfcf
