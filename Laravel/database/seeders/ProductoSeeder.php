<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiamos la tabla de platos viejos sin foto
        Producto::truncate();

        // 1. Lomo Saltado
        Producto::create([
            'nombre' => 'Lomo Saltado Criollo',
            'descripcion' => 'Trozos de lomo fino salteados al wok con cebolla, tomate y papas fritas crocantes.',
            'precio' => 38.50,
            'stock' => 20,
            'imagen' => 'lomo-saltado.jpg'
        ]);

        // 2. Ceviche Clásico
        Producto::create([
            'nombre' => 'Ceviche Clásico de Pescado',
            'descripcion' => 'Pesca del día marinada en limón norteño con camote glaseado y choclo tierno.',
            'precio' => 42.00,
            'stock' => 15,
            'imagen' => 'ceviche.jpg'
        ]);

        // 3. Causa Rellena
        Producto::create([
            'nombre' => 'Causa Rellena de Pollo',
            'descripcion' => 'Masa suave de papa amarilla con ají amarillo, rellena de pechuga de pollo y palta.',
            'precio' => 24.00,
            'stock' => 12,
            'imagen' => 'causa.jpg'
        ]);

        // 4. Chicha Morada
        Producto::create([
            'nombre' => 'Chicha Morada Artesanal (1L)',
            'descripcion' => 'Bebida tradicional de maíz morado hervido con piña, manzana, canela y clavo.',
            'precio' => 12.00,
            'stock' => 30,
            'imagen' => 'chicha.jpg'
        ]);

        // 5. Anticuchos de Corazón
        Producto::create([
            'nombre' => 'Anticuchos de Corazón',
            'descripcion' => 'Brochetas de corazón marinadas en ají panca con papas doradas y choclo tierno.',
            'precio' => 28.00,
            'stock' => 18,
            'imagen' => 'anticuchos.jpg'
        ]);
    }
}
