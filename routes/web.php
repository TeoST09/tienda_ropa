<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ColoresController;
use App\Http\Controllers\TallasController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::middleware('admin')->group(function () {
        Route::get('tallas', [TallasController::class, 'index'])
            ->name('tallas.index');
        Route::get('tallas/crear', [TallasController::class, 'create'])
            ->name('tallas.create');
        Route::post('tallas', [TallasController::class, 'store'])
            ->name('tallas.store');
        Route::get('tallas/{talla}/editar', [TallasController::class, 'edit'])
            ->name('tallas.edit');
        Route::put('tallas/{talla}', [TallasController::class, 'update'])
            ->name('tallas.update');
        Route::delete('tallas/{talla}', [TallasController::class, 'destroy'])
            ->name('tallas.destroy');

        // Colores

        Route::get('colores', [ColoresController::class, 'index'])
            ->name('colores.index');
        Route::get('colores/crear', [ColoresController::class, 'create'])
            ->name('colores.create');
        Route::post('colores', [ColoresController::class, 'store'])
            ->name('colores.store');
        Route::get('colores/{color}/editar', [ColoresController::class, 'edit'])
            ->name('colores.edit');
        Route::put('colores/{color}', [ColoresController::class, 'update'])
            ->name('colores.update');
        Route::delete('colores/{color}', [ColoresController::class, 'destroy'])
            ->name('colores.destroy');
    });
});

require __DIR__.'/settings.php';
