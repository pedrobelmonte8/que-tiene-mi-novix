<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GiftController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [GiftController::class, 'index'])->name('home');
    Route::post('/gifts', [GiftController::class, 'store'])->name('gifts.store');
    Route::put('/gifts/{gift}', [GiftController::class, 'update'])->name('gifts.update');
    Route::delete('/gifts/{gift}', [GiftController::class, 'destroy'])->name('gifts.destroy');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
