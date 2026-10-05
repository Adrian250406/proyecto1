<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reserva;
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReporteController extends Controller
{
    /**
     * 1. EXPORTACIÓN CSV / EXCEL DE RESERVAS
     * Compatible directamente con Microsoft Excel y Google Sheets (UTF-8 BOM).
     */
    public function exportarReservasCsv(Request $request): StreamedResponse
    {
        $filtroFecha = $request->input('fecha', 'todas');
        $filtroEstado = $request->input('estado');

        $query = reserva::query();

        // Filtro por Estado
        if (!empty($filtroEstado) && in_array($filtroEstado, ['Pendiente', 'Confirmada', 'Cancelada', 'Completada'])) {
            $query->where('estado', $filtroEstado);
        }

        // Filtro por Rango de Fechas (Zona Horaria Perú)
        $hoy = Carbon::now('America/Lima')->startOfDay();
        if ($filtroFecha === 'hoy') {
            $query->whereDate('fecha_reserva', $hoy->toDateString());
        } elseif ($filtroFecha === 'semana') {
            $query->whereBetween('fecha_reserva', [$hoy->toDateTimeString(), $hoy->copy()->addDays(7)->endOfDay()->toDateTimeString()]);
        } elseif ($filtroFecha === 'mes') {
            $query->whereMonth('fecha_reserva', $hoy->month)->whereYear('fecha_reserva', $hoy->year);
        }

        $reservas = $query->orderBy('fecha_reserva', 'desc')->get();
        $nombreArchivo = 'reservas_el_buen_sabor_' . Carbon::now('America/Lima')->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$nombreArchivo}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($reservas) {
            $output = fopen('php://output', 'w');

            // BOM UTF-8 para que Microsoft Excel reconozca tildes y caracteres en español
            fputs($output, "\xEF\xBB\xBF");

            // Cabeceras de columnas del CSV
            fputcsv($output, [
                'ID Reserva',
                'Cliente (Titular)',
                'Comensales (Pax)',
                'Teléfono de Contacto',
                'Fecha y Hora Pactada',
                'Mesa Asignada',
                'Estado Operativo',
                'Notas y Peticiones Especiales',
                'Fecha de Registro Web',
            ]);

            foreach ($reservas as $res) {
                fputcsv($output, [
                    '#' . $res->id,
                    $res->nombre,
                    $res->personas . ' Personas',
                    '+51 ' . $res->telefono,
                    Carbon::parse($res->fecha_reserva)->format('d/m/Y h:i A'),
                    $res->mesa ?? 'Sin Asignar',
                    $res->estado,
                    $res->notas ?? 'Ninguna',
                    $res->created_at ? Carbon::parse($res->created_at)->format('d/m/Y H:i:s') : 'N/A',
                ]);
            }

            fclose($output);
        }, 200, $headers);
    }

    /**
     * 2. HOJA DE SERVICIO DE SALÓN (PDF Imprimible para Metre y Mozos)
     */
    public function hojaServicioPdf(Request $request)
    {
        $fecha = $request->input('fecha', 'hoy');
        $hoy = Carbon::now('America/Lima');

        $query = reserva::query();

        if ($fecha === 'hoy') {
            $query->whereDate('fecha_reserva', $hoy->toDateString());
            $tituloFecha = 'HOY (' . $hoy->format('d/m/Y') . ')';
        } elseif ($fecha === 'manana') {
            $manana = $hoy->copy()->addDay();
            $query->whereDate('fecha_reserva', $manana->toDateString());
            $tituloFecha = 'MAÑANA (' . $manana->format('d/m/Y') . ')';
        } else {
            $tituloFecha = 'TODAS LAS RESERVAS REGISTRADAS';
        }

        $reservas = $query->orderBy('fecha_reserva', 'asc')->get();

        $metricas = [
            'total_reservas' => $reservas->count(),
            'total_comensales' => $reservas->sum('personas'),
            'mesas_asignadas' => $reservas->whereNotNull('mesa')->where('mesa', '!=', '')->count(),
            'salon_principal' => $reservas->filter(fn($r) => str_starts_with((string)$r->mesa, 'Mesa'))->count(),
            'terraza' => $reservas->filter(fn($r) => str_starts_with((string)$r->mesa, 'Terraza'))->count(),
            'vip' => $reservas->filter(fn($r) => str_starts_with((string)$r->mesa, 'VIP'))->count(),
        ];

        $pdf = Pdf::loadView('pdf.hoja-servicio-salon', compact('reservas', 'metricas', 'tituloFecha', 'hoy'));
        return $pdf->stream('hoja-servicio-salon-' . $hoy->format('Ymd') . '.pdf');
    }

    /**
     * 3. REPORTE DE INVENTARIO DE CARTA Y PLATOS (PDF para Cocina)
     */
    public function inventarioPlatosPdf()
    {
        $productos = Producto::orderBy('stock', 'asc')->get();
        $ahora = Carbon::now('America/Lima');

        $metricas = [
            'total_platos' => $productos->count(),
            'platos_disponibles' => $productos->where('stock', '>', 0)->count(),
            'platos_agotados' => $productos->where('stock', '<=', 0)->count(),
            'total_porciones' => $productos->sum('stock'),
            'valor_carta' => $productos->sum(fn($p) => $p->precio * $p->stock),
        ];

        $pdf = Pdf::loadView('pdf.inventario-platos', compact('productos', 'metricas', 'ahora'));
        return $pdf->stream('inventario-carta-platos-' . $ahora->format('Ymd') . '.pdf');
    }
}
