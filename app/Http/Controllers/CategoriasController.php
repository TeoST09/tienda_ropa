<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorias;
use Inertia\Inertia;

class CategoriasController extends Controller
{
    public function index(Request $request)
    {   
        $validate = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        $search = trim($validate['search'] ?? '');

        $query = Categorias::query()->orderBy('id');

        if ($search !== '') {
            $query->where('nombre', 'like', "%{$search}%");
        }

        $consulta = $query->get();

        return inertia('categorias/index', [
            'categorias' => $consulta
        ]);
    }

    public function create(){
        return inertia('categorias/create');
    }

    public function store(Request $request){
        $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:categorias,nombre'],
        ]);

        Categorias::create($request->all());

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => 'La categoría se creó correctamente.',
        ]);

        return to_route('categorias.index');
    }

    public function edit(Categorias $categoria){
        return inertia('categorias/edit',[
            'categoria' => $categoria
        ]);
    }

    public function update(Request $request, Categorias $categoria){
        $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:categorias,nombre,' . $categoria->id],
        ]);

        $categoria->update($request->all());

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => 'La categoría se actualizó correctamente.',
        ]);

        return to_route('categorias.index');
    }

    public function destroy(Categorias $categoria){
        $categoria->delete();

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => 'La categoría se eliminó correctamente.',
        ]);

        return to_route('categorias.index');
    }
}
