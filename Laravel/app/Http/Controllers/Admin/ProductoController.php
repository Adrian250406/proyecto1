<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    /**
     * 1. LISTADO MAESTRO DE PLATOS (/admin/productos)
     */
    public function index(Request $request)
    {
        $busqueda = $request->input('buscar');

        $productos = Producto::query()
            ->when($busqueda, function ($query, $busqueda) {
                $query->where('nombre', 'like', "%{$busqueda}%")
                    ->orWhere('descripcion', 'like', "%{$busqueda}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(8);

        return view('admin.productos.index', compact('productos', 'busqueda'));
    }

    /**
     * 2. FORMULARIO PARA CREAR NUEVO PLATO (/admin/productos/create)
     */
    public function create()
    {
        return view('admin.productos.create');
    }

    /**
     * 3. GUARDAR EL PLATO EN LA BASE DE DATOS (POST /admin/productos)
     */
    public function store(Request $request)
    {
        $validados = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string|max:500',
            'precio' => 'required|numeric|min:0.50|max:999.99',
            'stock' => 'required|integer|min:0|max:500',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072', // Máx 3MB
        ], [
            'nombre.required' => 'El nombre del plato es obligatorio.',
            'descripcion.required' => 'Ingresa una descripción para el comensal.',
            'precio.required' => 'El precio en Soles (PEN) es obligatorio.',
            'stock.required' => 'Indica la cantidad disponible en cocina.',
            'imagen.image' => 'El archivo debe ser una fotografía válida (JPG, PNG, WEBP).',
        ]);

        // Manejo de la subida de fotografía
        $nombreImagen = 'lomo-saltado.jpg'; // Imagen por defecto si no sube
        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $nombreImagen = Str::slug($validados['nombre']) . '-' . time() . '.' . $archivo->getClientOriginalExtension();
            $archivo->move(public_path('images/platos'), $nombreImagen);
        }

        $validados['imagen'] = $nombreImagen;

        Producto::create($validados);

        return redirect()->route('admin.productos.index')
            ->with('success', "¡Plato '{$validados['nombre']}' agregado con éxito a la carta!");
    }

    /**
     * 4. FORMULARIO PARA EDITAR UN PLATO (/admin/productos/{id}/edit)
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('admin.productos.edit', compact('producto'));
    }

    /**
     * 5. ACTUALIZAR LOS DATOS DEL PLATO (PUT /admin/productos/{id})
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $validados = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string|max:500',
            'precio' => 'required|numeric|min:0.50|max:999.99',
            'stock' => 'required|integer|min:0|max:500',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        // Si el usuario subió una nueva fotografía, la guardamos
        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $nombreImagen = Str::slug($validados['nombre']) . '-' . time() . '.' . $archivo->getClientOriginalExtension();
            $archivo->move(public_path('images/platos'), $nombreImagen);
            $validados['imagen'] = $nombreImagen;
        }

        $producto->update($validados);

        return redirect()->route('admin.productos.index')
            ->with('success', "¡Plato '{$producto->nombre}' actualizado correctamente!");
    }

    /**
     * 6. ELIMINAR UN PLATO DE LA CARTA (DELETE /admin/productos/{id})
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $nombre = $producto->nombre;
        $producto->delete();

        return redirect()->route('admin.productos.index')
            ->with('success', "El plato '{$nombre}' fue retirado de la carta gastronómica.");
    }

    /**
     * 7. CAMBIAR DISPONIBILIDAD RÁPIDA (Switch Disponible / Agotado)
     */
    public function toggleStock($id)
    {
        $producto = Producto::findOrFail($id);

        // Si tiene stock lo dejamos en 0 (Agotado), si está en 0 le asignamos 15 porciones
        $producto->stock = ($producto->stock > 0) ? 0 : 15;
        $producto->save();

        $estado = ($producto->stock > 0) ? 'Disponible (15 porciones)' : 'Agotado hoy';

        return redirect()->back()
            ->with('success', "Disponibilidad de '{$producto->nombre}' cambiada a: {$estado}.");
    }
}
