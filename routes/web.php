<?php

use App\Http\Controllers\TanamanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardSistem;
use App\Http\Controllers\AuthController;


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
    
//input data tabaman
Route::get('/tanaman/tambah', [TanamanController::class, 'create']);
Route::post('/tanaman/tambah', [TanamanController::class, 'store']);

//dashboard utama
Route::get('/dashboard', [TanamanController::class, 'index'])->name('dashboard');

//jadwal perawatan
Route::get('/jadwal-perawatan', [TanamanController::class, 'jadwalIndex'])->name('jadwal.index');
Route::post('/perawatan/update/{id}', [TanamanController::class, 'updatePerawatan'])->name('perawatan.update');