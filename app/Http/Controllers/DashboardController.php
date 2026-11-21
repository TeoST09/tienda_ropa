<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Colores;
use App\Models\Productos;
use App\Models\Talla;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        /** @var User|null $user */
        $user = $request->user();
        $isAdmin = (int) $user?->rol === 2;

        return Inertia::render('Dashboard', [
            'isAdmin' => $isAdmin,
            'stats' => $isAdmin ? [
                'products' => Productos::count(),
                'sizes' => Talla::count(),
                'colors' => Colores::count(),
                'categories' => Categorias::count(),
            ] : null,
        ]);
    }
}
