<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsuariosController extends Controller
{
    public function index(Request $request)
    {
        $validation = $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        $search = $validation['search'] ?? null;

        if ($search) {
            $consulta = User::where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->get();
        } else {
            $consulta = User::all();
        }

        return inertia('usuarios/index', [
            'usuarios' => $consulta,
            'search' => $search ?? '',
        ]);
    }

    public function create()
    {
        return inertia('usuarios/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|in:1,2',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => $request->rol,
        ]);

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => 'El usuario se creó correctamente.',
        ]);

        return to_route('usuarios.index');
    }

    public function show(User $usuario)
    {
        $usuario = User::findOrFail($usuario->id);

        return inertia('usuarios/show', [
            'usuario' => $usuario,
        ]);
    }

    public function edit(User $usuario)
    {
        return inertia('usuarios/edit', [
            'usuario' => $usuario,
        ]);
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
            'rol' => 'required|in:1,2',
        ]);

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->rol = $request->rol;

        if ($request->filled('password')) {
            $usuario->password = bcrypt($request->password);
        }

        $usuario->save();

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => 'El usuario se actualizó correctamente.',
        ]);

        return to_route('usuarios.index');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => 'El usuario se eliminó correctamente.',
        ]);

        return to_route('usuarios.index');
    }
}
