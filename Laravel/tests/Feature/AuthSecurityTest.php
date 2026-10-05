<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\reserva;

class AuthSecurityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Visitantes anónimos son expulsados de /admin/dashboard hacia /login (HTTP 302).
     */
    public function test_visitantes_no_autenticados_no_pueden_acceder_al_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    /**
     * Test 2: Un administrador autenticado puede ver el dashboard (HTTP 200).
     */
    public function test_administrador_autenticado_puede_ver_el_dashboard(): void
    {
        $admin = User::factory()->create([
            'name' => 'Adrián Admin',
            'email' => 'admin@elbuensabor.pe',
        ]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    /**
     * Test 3: El administrador puede actualizar el estado de una reserva.
     */
    public function test_administrador_puede_actualizar_estado_de_reserva(): void
    {
        $admin = User::factory()->create();

        $reserva = reserva::create([
            'nombre' => 'Cliente VIP',
            'personas' => 4,
            'telefono' => '987654321',
            'fecha_reserva' => now()->addDays(1),
            'estado' => 'Pendiente',
        ]);

        $response = $this->actingAs($admin)->put("/admin/reservas/{$reserva->id}/status", [
            'estado' => 'Confirmada',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reservas', [
            'id' => $reserva->id,
            'estado' => 'Confirmada',
        ]);
    }
}
