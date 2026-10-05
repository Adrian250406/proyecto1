<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\reserva;

class AdminReservaManagementTest extends TestCase
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
     * Test 1: El panel de gestión de salón carga correctamente con métricas y lista (HTTP 200).
     */
    public function test_admin_puede_ver_listado_de_reservas_y_metricas(): void
    {
        reserva::create([
            'nombre' => 'Carlos Mendoza',
            'personas' => 4,
            'telefono' => '987654321',
            'fecha_reserva' => now()->addDays(1),
            'estado' => 'Pendiente',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/reservas');

        $response->assertStatus(200);
        $response->assertSee('Gestión de Salón');
        $response->assertSee('Carlos Mendoza');
        $response->assertSee('987654321');
    }

    /**
     * Test 2: El admin puede asignar una mesa física del salón (Mesa 4, Terraza, VIP).
     */
    public function test_admin_puede_asignar_mesa_a_reserva(): void
    {
        $res = reserva::create([
            'nombre' => 'Lucía Ramos',
            'personas' => 2,
            'telefono' => '912345678',
            'fecha_reserva' => now()->addDays(2),
            'estado' => 'Pendiente',
        ]);

        $response = $this->actingAs($this->admin)->patch("/admin/reservas/{$res->id}/mesa", [
            'mesa' => 'Terraza 2',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reservas', [
            'id' => $res->id,
            'mesa' => 'Terraza 2',
        ]);
    }

    /**
     * Test 3: El admin puede actualizar el estado operativo (Confirmada, Completada, Cancelada).
     */
    public function test_admin_puede_actualizar_estado_de_reserva(): void
    {
        $res = reserva::create([
            'nombre' => 'Roberto Gómez',
            'personas' => 6,
            'telefono' => '955443322',
            'fecha_reserva' => now()->addDays(1),
            'estado' => 'Pendiente',
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/reservas/{$res->id}/status", [
            'estado' => 'Confirmada',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reservas', [
            'id' => $res->id,
            'estado' => 'Confirmada',
        ]);
    }

    /**
     * Test 4: El admin puede actualizar los datos completos (comensales, fecha, notas, mesa).
     */
    public function test_admin_puede_actualizar_datos_completos_de_reserva(): void
    {
        $res = reserva::create([
            'nombre' => 'Familia Quispe',
            'personas' => 5,
            'telefono' => '944332211',
            'fecha_reserva' => now()->addDays(1),
            'estado' => 'Pendiente',
        ]);

        $datosActualizados = [
            'nombre' => 'Familia Quispe Especial',
            'personas' => 8,
            'telefono' => '944332211',
            'fecha_reserva' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'mesa' => 'VIP Lounge 1',
            'estado' => 'Confirmada',
            'notas' => 'Celebración de bodas de plata, traer champagne.',
        ];

        $response = $this->actingAs($this->admin)->put("/admin/reservas/{$res->id}", $datosActualizados);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reservas', [
            'id' => $res->id,
            'nombre' => 'Familia Quispe Especial',
            'personas' => 8,
            'mesa' => 'VIP Lounge 1',
            'notas' => 'Celebración de bodas de plata, traer champagne.',
        ]);
    }

    /**
     * Test 5: El admin puede eliminar una reserva del sistema.
     */
    public function test_admin_puede_eliminar_reserva(): void
    {
        $res = reserva::create([
            'nombre' => 'Reserva Cancelada Antigua',
            'personas' => 2,
            'telefono' => '999888777',
            'fecha_reserva' => now()->addDays(3),
            'estado' => 'Cancelada',
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/reservas/{$res->id}");

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('reservas', [
            'id' => $res->id,
        ]);
    }

    /**
     * Test 6: El buscador filtra reservas por nombre o mesa.
     */
    public function test_admin_puede_filtrar_reservas_por_busqueda(): void
    {
        reserva::create([
            'nombre' => 'Ana Paula Valdivia',
            'personas' => 3,
            'telefono' => '966554433',
            'fecha_reserva' => now()->addDays(1),
            'mesa' => 'Mesa 7',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/reservas?buscar=Valdivia');

        $response->assertStatus(200);
        $response->assertSee('Ana Paula Valdivia');
    }
}
