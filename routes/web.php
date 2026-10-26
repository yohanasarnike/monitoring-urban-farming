<?php

use App\Http\Controllers\TanamanController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });




Route::get('/dashboard', function () {
    return view('dashboard-sistem');
})->name('dashboard');

Route::get('/tanaman/tambah', [TanamanController::class, 'create']);
Route::post('/tanaman/tambah', [TanamanController::class, 'store']);


Route::get('/dashboard', [TanamanController::class, 'index']);

Route::get('/jadwal-perawatan', [TanamanController::class, 'jadwalIndex'])->name('jadwal.index');
Route::post('/perawatan/update/{id}', [TanamanController::class, 'updatePerawatan'])->name('perawatan.update');