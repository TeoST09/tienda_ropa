<?php

use App\Http\Controllers\TallasController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

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
    });
});

require __DIR__.'/settings.php';
