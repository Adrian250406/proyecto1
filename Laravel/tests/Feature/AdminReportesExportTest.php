<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\reserva;
use App\Models\Producto;

class AdminReportesExportTest extends TestCase
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
     * Test 1: Usuarios no autenticados son rechazados al intentar exportar (HTTP 302 a /login).
     */
    public function test_visitante_no_autenticado_no_puede_exportar_reportes(): void
    {
        $responseCsv = $this->get('/admin/reservas/exportar/csv');
        $responseCsv->assertRedirect('/login');

        $responseSalonPdf = $this->get('/admin/reservas/reporte/hoja-servicio-pdf');
        $responseSalonPdf->assertRedirect('/login');

        $responseInventarioPdf = $this->get('/admin/productos/reporte/inventario-pdf');
        $responseInventarioPdf->assertRedirect('/login');
    }

    /**
     * Test 2: El administrador puede descargar el archivo CSV de reservas con BOM UTF-8 y cabeceras correctas.
     */
    public function test_admin_puede_exportar_reservas_en_formato_csv(): void
    {
        reserva::create([
            'nombre' => 'María Elena Flores',
            'personas' => 5,
            'telefono' => '988776655',
            'fecha_reserva' => now('America/Lima')->addDays(1),
            'mesa' => 'Terraza 1',
            'estado' => 'Confirmada',
            'notas' => 'Mesa cerca al jardín',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/reservas/exportar/csv');

        $response->assertStatus(200);
        $this->assertStringContainsString('text/csv', (string)$response->headers->get('Content-Type'));
        $this->assertStringContainsString('attachment; filename=', (string)$response->headers->get('Content-Disposition'));
        
        $streamedContent = $response->streamedContent();
        $this->assertStringContainsString('María Elena Flores', $streamedContent);
        $this->assertStringContainsString('988776655', $streamedContent);
        $this->assertStringContainsString('Terraza 1', $streamedContent);
        $this->assertStringContainsString('Confirmada', $streamedContent);
    }

    /**
     * Test 3: El administrador puede generar e imprimir la Hoja de Servicio de Salón en PDF.
     */
    public function test_admin_puede_generar_hoja_de_servicio_salon_en_pdf(): void
    {
        reserva::create([
            'nombre' => 'Javier Alarcón',
            'personas' => 4,
            'telefono' => '977665544',
            'fecha_reserva' => now('America/Lima'),
            'mesa' => 'Mesa 3',
            'estado' => 'Pendiente',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/reservas/reporte/hoja-servicio-pdf');

        $response->assertStatus(200);
        $this->assertStringContainsString('application/pdf', (string)$response->headers->get('Content-Type'));
    }

    /**
     * Test 4: El administrador puede generar el Reporte de Inventario de Platos y Carta en PDF.
     */
    public function test_admin_puede_generar_reporte_de_inventario_de_platos_en_pdf(): void
    {
        Producto::create([
            'nombre' => 'Lomo Saltado Gourmet',
            'descripcion' => 'Lomo fino con cebolla y tomate.',
            'precio' => 48.00,
            'stock' => 20,
            'imagen' => 'lomo.jpg',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/productos/reporte/inventario-pdf');

        $response->assertStatus(200);
        $this->assertStringContainsString('application/pdf', (string)$response->headers->get('Content-Type'));
    }
}
