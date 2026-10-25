<?php

use App\Http\Controllers\TanamanController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });


// Halaman Login
Route::get('/login', function () {
    return view('auth.login');
    
});
Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/tanaman/tambah', [TanamanController::class, 'create']);
Route::post('/tanaman/tambah', [TanamanController::class, 'store']);


Route::get('/dashboard', [TanamanController::class, 'index']);

Route::get('/jadwal-perawatan', [TanamanController::class, 'jadwalIndex'])->name('jadwal.index');