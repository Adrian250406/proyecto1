<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\reserva;

class ReservaValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Comprobar que la pantalla de reservas carga con HTTP 200.
     */
    public function test_la_pagina_de_reservas_carga_correctamente(): void
    {
        $response = $this->get('/reservas');
        $response->assertStatus(200);
        $response->assertSee('Reserva tu Mesa');
    }

    /**
     * Test 2: Comprobar que se puede registrar una reserva válida.
     */
    public function test_se_puede_crear_una_reserva_con_datos_validos(): void
    {
        $fechaFutura = now()->addDays(2)->format('Y-m-d H:i:s');

        $datos = [
            'nombre' => 'Carlos Mendoza',
            'personas' => 4,
            'telefono' => '987654321',
            'fecha_reserva' => $fechaFutura,
        ];

        $response = $this->post('/reservas', $datos);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reservas', [
            'nombre' => 'Carlos Mendoza',
            'telefono' => '987654321',
            'personas' => 4,
            'estado' => 'Pendiente',
        ]);
    }

    /**
     * Test 3: Comprobar que rechace teléfonos de menos de 9 dígitos.
     */
    public function test_falla_si_el_telefono_es_invalido(): void
    {
        $fechaFutura = now()->addDays(2)->format('Y-m-d H:i:s');

        $datos = [
            'nombre' => 'Juan Perez',
            'personas' => 2,
            'telefono' => '12345', // Inválido: solo 5 dígitos
            'fecha_reserva' => $fechaFutura,
        ];

        $response = $this->post('/reservas', $datos);
        $response->assertSessionHasErrors('telefono');
    }

    /**
     * Test 4: Comprobar que se puede descargar el comprobante en PDF.
     */
    public function test_se_puede_descargar_el_ticket_en_pdf(): void
    {
        $reserva = reserva::create([
            'nombre' => 'Ana Lucia Gomez',
            'personas' => 2,
            'telefono' => '999888777',
            'fecha_reserva' => now()->addDays(1),
            'estado' => 'Pendiente',
        ]);

        $response = $this->get("/reservas/{$reserva->id}/pdf");

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }
}
