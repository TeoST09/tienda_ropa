<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;
use Inertia\Inertia;

class CarritoController extends Controller
{

    public function index(){
        $carrito = session()->get('carrito', []);
        
        $productos = Productos::whereIn('id', array_keys($carrito))->get()->map(function ($producto) use ($carrito) {
            $producto->cantidad = $carrito[$producto->id];
            return $producto;
        });

        return inertia('carrito/index', [
            'carrito' => $carrito,
            'productos' => $productos,
        ]);
    }

    public function agregarCarrito(Request $request){

        $request->validate([
            'producto_id' => 'required|exists:productos,id',
        ]);

        $productoId = $request->input('producto_id');

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$productoId])) {
            $carrito[$productoId]++;
        } else {
            $carrito[$productoId] = 1;
        }

        session()->put('carrito', $carrito);

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => 'El producto se agregó correctamente al carrito.',
        ]);

        return redirect()->back();
    }

    public function disminuirCarrito(Request $request){
        
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
        ]);

        $productoId = $request->input('producto_id');

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$productoId])) {
            if ($carrito[$productoId] > 1) {
                $carrito[$productoId]--;
            } else {
                unset($carrito[$productoId]);
            }
        }

        session()->put('carrito', $carrito);

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => 'El producto se disminuyó correctamente del carrito.',
        ]);

        return redirect()->back();
    }

    public function eliminarCarrito(Request $request){

        $request->validate([
            'producto_id' => 'required|exists:productos,id',
        ]);

        $productoId = $request->input('producto_id');

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$productoId])) {
            unset($carrito[$productoId]);
        }

        session()->put('carrito', $carrito);

        Inertia::flash('alert', [
            'type' => 'success',
            'message' => 'El producto se eliminó correctamente del carrito.',
        ]);

        return redirect()->back();  
    }
}
