<?php

use App\Http\Controllers\TanamanController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });


// Halaman Login & Register
data:
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']); // Proses login

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/dashboard', function () {
    return view('dashboard-sistem');
})->name('dashboard');

Route::get('/tanaman/tambah', [TanamanController::class, 'create']);
Route::post('/tanaman/tambah', [TanamanController::class, 'store']);


Route::get('/dashboard', [TanamanController::class, 'index']);

Route::get('/jadwal-perawatan', [TanamanController::class, 'jadwalIndex'])->name('jadwal.index');
Route::post('/perawatan/update/{id}', [TanamanController::class, 'updatePerawatan'])->name('perawatan.update');