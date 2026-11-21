<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Colores;
use App\Models\Productos;
use App\Models\Talla;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductosController extends Controller
{
    public function index(Request $request)
    {

        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'talla_id' => ['nullable', 'integer', 'exists:tallas,id'],
            'color_id' => ['nullable', 'integer', 'exists:colores,id'],
        ]);

        $search = trim($filters['search'] ?? '');

        $query = Productos::query()
            ->with(['categoria', 'color', 'talla'])
            ->orderBy('id');

        if ($search !== '') {
            $query->where('nombre', 'like', "%{$search}%");
        }

        if (isset($filters['stock'])) {
            $query->where('stock', $filters['stock']);
        }

        if (isset($filters['talla_id'])) {
            $query->where('talla_id', $filters['talla_id']);
        }

        if (isset($filters['color_id'])) {
            $query->where('color_id', $filters['color_id']);
        }

        $productos = $query->get();

        return inertia('productos/admin/index', [
            'productos' => $productos,
            'search' => $search,
            'stock' => $filters['stock'] ?? '',
            'talla_id' => $filters['talla_id'] ?? '',
            'color_id' => $filters['color_id'] ?? '',
            'tallas' => Talla::orderBy('nombre')->get(['id', 'nombre']),
            'colores' => Colores::orderBy('nombre')->get(['id', 'nombre']),
        ]);
    }

    public function create()
    {
        return inertia('productos/admin/create', [
            'categorias' => Categorias::orderBy('nombre')->get(['id', 'nombre']),
            'tallas' => Talla::orderBy('nombre')->get(['id', 'nombre']),
            'colores' => Colores::orderBy('nombre')->get(['id', 'nombre']),
        ]);
    }

    public function show(Productos $producto)
    {
        $producto->load(['categoria', 'color', 'talla']);

        return inertia('productos/admin/show', [
            'producto' => $producto,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'oferta' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'color_id' => 'required|exists:colores,id',
            'talla_id' => 'required|exists:tallas,id',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $nombre = time().'_'.Str::random(8).'.'.$archivo->extension();

            $archivo->move(public_path('imagenes/productos'), $nombre);
            $validated['imagen'] = 'productos/'.$nombre;
        } else {
            $validated['imagen'] = 'productos/default.png';
        }

        $producto = Productos::create($validated);

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => 'El producto se creó correctamente.',
        ]);

        return to_route('productos.admin.index');
    }

    public function edit(Productos $producto)
    {
        return inertia('productos/admin/edit', [
            'producto' => $producto,
            'categorias' => Categorias::orderBy('nombre')->get(['id', 'nombre']),
            'tallas' => Talla::orderBy('nombre')->get(['id', 'nombre']),
            'colores' => Colores::orderBy('nombre')->get(['id', 'nombre']),
        ]);
    }

    public function update(Request $request, Productos $producto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'oferta' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'color_id' => 'required|exists:colores,id',
            'talla_id' => 'required|exists:tallas,id',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if ($producto->imagen && file_exists(public_path($producto->imagen))) {
                File::delete(public_path($producto->imagen));
            }
        }

        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $nombre = time().'_'.Str::random(8).'.'.$archivo->extension();

            $archivo->move(public_path('imagenes/productos'), $nombre);
            $validated['imagen'] = 'productos/'.$nombre;
        } else {
            unset($validated['imagen']);
        }

        $producto->update($validated);

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => 'El producto se actualizó correctamente.',
        ]);

        return to_route('productos.admin.index');
    }

    public function destroy(Productos $producto)
    {
        $producto->delete();

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => 'El producto se eliminó correctamente.',
        ]);

        return to_route('productos.admin.index');
    }
}
