<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // 1. GET /api/productos (Listar todos los platos en JSON)
    public function index()
    {
        return response()->json(Producto::all(), 200);
    }

    // 2. POST /api/productos (Registrar un plato desde Postman/API)
    public function store(Request $request)
    {
        $validados = $request->validate([
            'nombre'      => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);

        $producto = Producto::create($validados);

        return response()->json([
            'status'  => true,
            'message' => 'Producto creado con éxito en la carta',
            'data'    => $producto
        ], 201);
    }

    // 3. GET /api/productos/{id} (Consultar un plato por su ID)
    public function show($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status'  => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $producto
        ], 200);
    }

    // 4. PUT /api/productos/{id} (Actualizar precio o stock de un plato)
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status'  => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $validados = $request->validate([
            'nombre'      => 'sometimes|required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio'      => 'sometimes|required|numeric|min:0',
            'stock'       => 'sometimes|required|integer|min:0',
        ]);

        $producto->update($validados);

        return response()->json([
            'status'  => true,
            'message' => 'Producto actualizado exitosamente',
            'data'    => $producto
        ], 200);
    }

    // 5. DELETE /api/productos/{id} (Eliminar un plato de la carta)
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status'  => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $producto->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Producto eliminado de la base de datos'
        ], 200);
    }
}
