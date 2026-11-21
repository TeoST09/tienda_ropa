<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ColoresController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\TallasController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('productos', [ProductosController::class, 'indexUser'])
        ->name('productos.indexUser');

    Route::get('carrito', [CarritoController::class, 'index'])
        ->name('carrito.ver');
    Route::post('carrito/agregar', [CarritoController::class, 'agregarCarrito'])
        ->name('carrito.agregar');
    Route::post('carrito/disminuir', [CarritoController::class, 'disminuirCarrito'])
        ->name('carrito.disminuir');

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

        // Categorías

        Route::get('categorias', [CategoriasController::class, 'index'])
            ->name('categorias.index');
        Route::get('categorias/crear', [CategoriasController::class, 'create'])
            ->name('categorias.create');
        Route::post('categorias', [CategoriasController::class, 'store'])
            ->name('categorias.store');
        Route::get('categorias/{categoria}/editar', [CategoriasController::class, 'edit'])
            ->name('categorias.edit');
        Route::put('categorias/{categoria}', [CategoriasController::class, 'update'])
            ->name('categorias.update');
        Route::delete('categorias/{categoria}', [CategoriasController::class, 'destroy'])
            ->name('categorias.destroy');

        // Productos

        Route::get('productos', [ProductosController::class, 'indexUser'])
            ->name('productos.indexUser');
        
        Route::get('productos/showUser/{producto}', [ProductosController::class, 'showUser'])
            ->name('productos.showUser');

        Route::get('productos/admin', [ProductosController::class, 'index'])
            ->name('productos.admin.index');
        Route::get('productos/admin/crear', [ProductosController::class, 'create'])
            ->name('productos.admin.create');
        Route::post('productos/admin', [ProductosController::class, 'store'])
            ->name('productos.admin.store');
        Route::get('productos/admin/{producto}', [ProductosController::class, 'show'])
            ->name('productos.admin.show');
        Route::get('productos/admin/{producto}/editar', [ProductosController::class, 'edit'])
            ->name('productos.admin.edit');
        Route::put('productos/admin/{producto}', [ProductosController::class, 'update'])
            ->name('productos.admin.update');
        Route::delete('productos/admin/{producto}', [ProductosController::class, 'destroy'])
            ->name('productos.admin.destroy');

        // Usuarios

        Route::get('usuarios', [UsuariosController::class, 'index'])
            ->name('usuarios.index');
        Route::get('usuarios/crear', [UsuariosController::class, 'create'])
            ->name('usuarios.create');
        Route::get('usuarios/{usuario}', [UsuariosController::class, 'show']);
        Route::post('usuarios', [UsuariosController::class, 'store'])
            ->name('usuarios.store');
        Route::get('usuarios/{usuario}/editar', [UsuariosController::class, 'edit'])
            ->name('usuarios.edit');
        Route::put('usuarios/{usuario}', [UsuariosController::class, 'update'])
            ->name('usuarios.update');
        Route::delete('usuarios/{usuario}', [UsuariosController::class, 'destroy'])
            ->name('usuarios.destroy');

    });
});

require __DIR__.'/settings.php';
