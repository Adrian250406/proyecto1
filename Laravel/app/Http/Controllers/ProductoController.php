<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validar los datos que vienen del formulario
        $validados = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // 2. Registrar en la base de datos (Forma 1: create)
        $producto = Producto::create($validados);

        // Forma 2 alternativa (instancia manual):
        // $producto = new Producto();
        // $producto->nombre = $request->nombre;
        // $producto->precio = $request->precio;
        // $producto->save();

        // 3. Responder / Redireccionar
        return redirect()->route('productos.index')
            ->with('success', 'Producto registrado exitosamente.');
    }
}
