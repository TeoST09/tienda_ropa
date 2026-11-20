<?php

namespace App\Http\Controllers;

use App\Models\Talla;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TallasController extends Controller
{
    public function index(Request $request): Response
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        $search = trim($validated['search'] ?? '');
        $query = Talla::query()->orderBy('id');

        if ($search !== '') {
            $query->where('nombre', 'like', "%{$search}%");
        }

        return Inertia::render('tallas/index', [
            'tallas' => $query->get(),
            'search' => $search,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('tallas/create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:10', 'unique:tallas,nombre'],
        ]);

        Talla::create($validated);

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => 'La talla se creó correctamente.',
        ]);

        return to_route('tallas.index');
    }

    public function edit(Talla $talla): Response
    {
        return Inertia::render('tallas/edit', [
            'talla' => $talla,
        ]);
    }

    public function update(Request $request, Talla $talla): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:10',
                Rule::unique('tallas', 'nombre')->ignore($talla->id),
            ],
        ]);

        $talla->update($validated);

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => 'La talla se actualizó correctamente.',
        ]);

        return to_route('tallas.index');
    }

    public function destroy(Talla $talla): RedirectResponse
    {
        $talla->delete();

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => "La talla {$talla->nombre} se eliminó correctamente.",
        ]);

        return to_route('tallas.index');
    }
}
