<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Producto::create([
            'nombre' => 'Lomo Saltado Criollo',
            'descripcion' => 'Trozos de lomo fino salteados al wok con cebolla, tomate y papas fritas crocantes.',
            'precio' => 38.50,
            'stock' => 20,
        ]);

        Producto::create([
            'nombre' => 'Ceviche Clásico de Pescado',
            'descripcion' => 'Pesca del día marinada en limón norteño con camote glaseado y choclo tierno.',
            'precio' => 42.00,
            'stock' => 15,
        ]);

        Producto::create([
            'nombre' => 'Causa Rellena de Pollo',
            'descripcion' => 'Masa suave de papa amarilla con ají amarillo, rellena de pechuga de pollo y palta.',
            'precio' => 24.00,
            'stock' => 12,
        ]);

        Producto::create([
            'nombre' => 'Chicha Morada Artesanal (1L)',
            'descripcion' => 'Bebida tradicional de maíz morado hervido con piña, manzana, canela y clavo.',
            'precio' => 12.00,
            'stock' => 30,
        ]);
    }
}
