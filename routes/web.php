<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\GiftListController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [GiftController::class, 'index'])->name('home');

    // Gestión de artículos (Gifts)
    Route::post('/gifts', [GiftController::class, 'store'])->name('gifts.store');
    Route::put('/gifts/{gift}', [GiftController::class, 'update'])->name('gifts.update');
    Route::delete('/gifts/{gift}', [GiftController::class, 'destroy'])->name('gifts.destroy');

    // Gestión de listas (Gift Lists)
    Route::post('/gift-lists', [GiftListController::class, 'store'])->name('gift-lists.store');
    Route::put('/gift-lists/{giftList}', [GiftListController::class, 'update'])->name('gift-lists.update');
    Route::delete('/gift-lists/{giftList}', [GiftListController::class, 'destroy'])->name('gift-lists.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
