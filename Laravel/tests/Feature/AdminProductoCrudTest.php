<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Producto;

class AdminProductoCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'name' => 'Adrián Admin',
            'email' => 'admin@buensabor.pe',
        ]);
    }

    /**
     * Test 1: El listado maestro de platos carga exitosamente (HTTP 200) para el admin.
     */
    public function test_admin_puede_ver_listado_de_platos(): void
    {
        Producto::create([
            'nombre' => 'Ceviche Clásico',
            'descripcion' => 'Pesca del día con limón.',
            'precio' => 42.00,
            'stock' => 15,
            'imagen' => 'ceviche.jpg',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/productos');

        $response->assertStatus(200);
        $response->assertSee('Gestión de Platos');
        $response->assertSee('Ceviche Clásico');
        $response->assertSee('42.00');
    }

    /**
     * Test 2: El formulario de creación carga correctamente.
     */
    public function test_admin_puede_ver_formulario_de_creacion(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/productos/create');

        $response->assertStatus(200);
        $response->assertSee('Nuevo Plato Criollo');
    }

    /**
     * Test 3: El admin puede crear un nuevo plato exitosamente.
     */
    public function test_admin_puede_crear_nuevo_plato(): void
    {
        $datos = [
            'nombre' => 'Ají de Gallina Cremoso',
            'descripcion' => 'Pechuga deshilachada en crema de ají amarillo con papas y arroz.',
            'precio' => 32.50,
            'stock' => 25,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/productos', $datos);

        $response->assertRedirect('/admin/productos');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('productos', [
            'nombre' => 'Ají de Gallina Cremoso',
            'precio' => '32.50',
            'stock' => 25,
        ]);
    }

    /**
     * Test 4: El formulario de edición carga los datos del plato.
     */
    public function test_admin_puede_ver_formulario_de_edicion(): void
    {
        $plato = Producto::create([
            'nombre' => 'Seco de Res',
            'descripcion' => 'Carne tierna al culantro con frijoles.',
            'precio' => 39.00,
            'stock' => 10,
            'imagen' => 'seco.jpg',
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/productos/{$plato->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Editar Plato: Seco de Res');
        $response->assertSee('39.00');
    }

    /**
     * Test 5: El admin puede actualizar precio y stock del plato.
     */
    public function test_admin_puede_actualizar_plato(): void
    {
        $plato = Producto::create([
            'nombre' => 'Arroz Chaufa',
            'descripcion' => 'Arroz salteado al wok.',
            'precio' => 28.00,
            'stock' => 12,
            'imagen' => 'chaufa.jpg',
        ]);

        $datosActualizados = [
            'nombre' => 'Arroz Chaufa Especial',
            'descripcion' => 'Arroz al wok con pollo, carne y chancho.',
            'precio' => 34.00,
            'stock' => 30,
        ];

        $response = $this->actingAs($this->admin)->put("/admin/productos/{$plato->id}", $datosActualizados);

        $response->assertRedirect('/admin/productos');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('productos', [
            'id' => $plato->id,
            'nombre' => 'Arroz Chaufa Especial',
            'precio' => '34.00',
            'stock' => 30,
        ]);
    }

    /**
     * Test 6: El admin puede cambiar la disponibilidad rápida (Agotar / Activar).
     */
    public function test_admin_puede_cambiar_disponibilidad_toggle_stock(): void
    {
        $plato = Producto::create([
            'nombre' => 'Papa a la Huancaína',
            'descripcion' => 'Papas con crema de queso y ají.',
            'precio' => 22.00,
            'stock' => 10,
            'imagen' => 'papa.jpg',
        ]);

        // Cambiar a Agotado (stock = 0)
        $response = $this->actingAs($this->admin)->patch("/admin/productos/{$plato->id}/toggle-stock");
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('productos', [
            'id' => $plato->id,
            'stock' => 0,
        ]);

        // Volver a Activar (stock = 15)
        $response2 = $this->actingAs($this->admin)->patch("/admin/productos/{$plato->id}/toggle-stock");
        $response2->assertSessionHas('success');

        $this->assertDatabaseHas('productos', [
            'id' => $plato->id,
            'stock' => 15,
        ]);
    }

    /**
     * Test 7: El admin puede eliminar un plato de la carta.
     */
    public function test_admin_puede_eliminar_plato(): void
    {
        $plato = Producto::create([
            'nombre' => 'Plato Temporal',
            'descripcion' => 'Solo por temporada.',
            'precio' => 19.90,
            'stock' => 5,
            'imagen' => 'temp.jpg',
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/productos/{$plato->id}");

        $response->assertRedirect('/admin/productos');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('productos', [
            'id' => $plato->id,
        ]);
    }
}
