<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Producto;

class ProductoApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Verificar que la API /api/productos devuelva la lista de platos en JSON.
     */
    public function test_la_api_retorna_lista_de_productos_json(): void
    {
        Producto::create([
            'nombre' => 'Ceviche Mixto Especial',
            'descripcion' => 'Pesca fresca con mariscos, camote y choclo.',
            'precio' => 45.00,
            'stock' => 10,
            'imagen' => 'ceviche.jpg'
        ]);

        $response = $this->getJson('/api/productos');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => 'Ceviche Mixto Especial',
            'precio' => '45.00',
        ]);
    }

    /**
     * Test 2: Consultar un plato individual por su ID (/api/productos/{id}).
     */
    public function test_la_api_retorna_un_producto_especifico(): void
    {
        $plato = Producto::create([
            'nombre' => 'Lomo Saltado',
            'descripcion' => 'Lomo salteado al wok.',
            'precio' => 38.50,
            'stock' => 15,
            'imagen' => 'lomo.jpg'
        ]);

        $response = $this->getJson("/api/productos/{$plato->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => 'Lomo Saltado',
            'stock' => 15,
        ]);
    }
}
