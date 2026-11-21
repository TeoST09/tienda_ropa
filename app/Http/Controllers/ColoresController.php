<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colores;
use Inertia\Inertia;

class ColoresController extends Controller
{
    public function index(Request $request)
    {

        $request = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        $search = trim($request['search'] ?? '');

        $query = Colores::query()->orderBy('id');

        if ($search !== '') {
            $query->where('nombre', 'like', "%{$search}%");
        }

        $consulta = $query->get();
        return inertia('colores/index', [
            'colores' => $consulta
        ]);
    }

    public function create()
    {
        return inertia('colores/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:colores,nombre'],
        ]);

        Colores::create($request->all());

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => 'El color se creó correctamente.',
        ]);

        return to_route('colores.index');
    }

    public function edit(Colores $color){
        return inertia('colores/edit',[
            'color' => $color
        ]);
    }

    public function update(Request $request, Colores $color){
        $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:colores,nombre,'.$color->id],
        ]);

        $color->update($request->all());

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => 'El color se actualizó correctamente.',
        ]);

        return to_route('colores.index');
    }

    public function destroy(Colores $color){
        $color->delete();

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => 'El color se eliminó correctamente.',
        ]);

        return to_route('colores.index');
    }
}
