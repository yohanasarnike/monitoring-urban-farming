<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardSistem;
use App\Http\Controllers\AuthController;

// Dashboard sistem
Route::get('/dashboard.sistem', [DashboardSistem::class, 'index'])
    ->name('dashboard');

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
