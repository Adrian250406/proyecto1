<?php

namespace App\Http\Controllers;

use App\Models\reserva;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * 1. LISTADO AVANZADO DE RESERVAS (Panel Administrativo con Filtros y KPIs)
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $filtroEstado = $request->input('estado');
        $filtroFecha = $request->input('fecha', 'todas');

        $query = reserva::query();

        // 🔍 Búsqueda por Nombre, Teléfono, Mesa o Notas
        if (!empty($buscar)) {
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('telefono', 'like', "%{$buscar}%")
                  ->orWhere('mesa', 'like', "%{$buscar}%")
                  ->orWhere('notas', 'like', "%{$buscar}%");
            });
        }

        // 🏷️ Filtro por Estado Operativo
        if (!empty($filtroEstado) && in_array($filtroEstado, ['Pendiente', 'Confirmada', 'Cancelada', 'Completada'])) {
            $query->where('estado', $filtroEstado);
        }

        // 📅 Filtro por Rango de Fechas (Zona Horaria Perú)
        $hoy = Carbon::now('America/Lima')->startOfDay();
        if ($filtroFecha === 'hoy') {
            $query->whereDate('fecha_reserva', $hoy->toDateString());
        } elseif ($filtroFecha === 'manana') {
            $query->whereDate('fecha_reserva', $hoy->copy()->addDay()->toDateString());
        } elseif ($filtroFecha === 'semana') {
            $query->whereBetween('fecha_reserva', [$hoy->toDateTimeString(), $hoy->copy()->addDays(7)->endOfDay()->toDateTimeString()]);
        }

        $reservas = $query->orderBy('fecha_reserva', 'desc')->paginate(10);

        // 📊 Métricas Operativas de Salón
        $metricas = [
            'total_hoy' => reserva::whereDate('fecha_reserva', $hoy->toDateString())->count(),
            'comensales_hoy' => reserva::whereDate('fecha_reserva', $hoy->toDateString())->sum('personas'),
            'mesas_asignadas' => reserva::whereNotNull('mesa')->where('mesa', '!=', '')->count(),
            'pendientes' => reserva::where('estado', 'Pendiente')->count(),
        ];

        return view('admin.reservas', compact('reservas', 'buscar', 'filtroEstado', 'filtroFecha', 'metricas'));
    }

    /**
     * 2. REGISTRAR UNA NUEVA RESERVA (Público / PWA)
     */
    public function store(Request $request)
    {
        // 🕒 Hora exacta en Perú + 30 minutos mínimos de anticipación
        $minimoTiempo = now('America/Lima')->addMinutes(30);

        // 🛡️ REGLAS DE VALIDACIÓN ESTRICTAS
        $validados = $request->validate([
            'nombre' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'personas' => 'required|integer|min:1|max:20',
            'telefono' => [
                'required',
                'regex:/^9[0-9]{8}$/'
            ],
            'fecha_reserva' => [
                'required',
                'date',
                'after_or_equal:' . $minimoTiempo->toDateTimeString()
            ],
            'notas' => 'nullable|string|max:300',
        ], [
            'nombre.required' => 'Por favor, ingresa tu nombre.',
            'nombre.min' => 'El nombre debe tener al menos 3 letras.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'personas.min' => 'La reserva mínima es para 1 persona.',
            'personas.max' => 'El aforo máximo por reserva web es de 20 personas.',
            'telefono.required' => 'El teléfono celular es obligatorio.',
            'telefono.regex' => 'El teléfono debe ser un celular de Perú válido (9 dígitos y empezar con 9).',
            'fecha_reserva.required' => 'Debes seleccionar la fecha y hora de la reserva.',
            'fecha_reserva.after_or_equal' => 'Las reservas deben realizarse con al menos 30 minutos de anticipación.',
        ]);

        $validados['estado'] = 'Pendiente';

        $reserva = reserva::create($validados);

        return redirect()->back()
            ->with('success', "¡Mesa reservada exitosamente para {$reserva->nombre}! Tu código es #{$reserva->id}.")
            ->with('reserva_id', $reserva->id);
    }

    /**
     * 3. DESCARGAR COMPROBANTE DIGITAL EN PDF
     */
    public function descargarPdf($id)
    {
        $reserva = reserva::findOrFail($id);
        $pdf = Pdf::loadView('pdf.ticket-reserva', compact('reserva'));
        return $pdf->stream("ticket-reserva-{$reserva->id}.pdf");
    }

    /**
     * 4. CAMBIAR ESTADO OPERATIVO (Pendiente, Confirmada, Cancelada, Completada)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|string|in:Pendiente,Confirmada,Cancelada,Completada'
        ]);

        $reserva = reserva::findOrFail($id);
        $reserva->update(['estado' => $request->estado]);

        return redirect()->back()->with('success', "Reserva #{$id} ({$reserva->nombre}) actualizada a estado: {$request->estado}.");
    }

    /**
     * 5. ASIGNACIÓN RÁPIDA DE MESA DE SALÓN
     */
    public function assignTable(Request $request, $id)
    {
        $request->validate([
            'mesa' => 'nullable|string|max:50'
        ]);

        $reserva = reserva::findOrFail($id);
        $reserva->update(['mesa' => $request->mesa]);

        $mensajeMesa = !empty($request->mesa) ? "asignada a {$request->mesa}" : "sin mesa asignada";
        return redirect()->back()->with('success', "Reserva #{$id} de {$reserva->nombre} ahora está {$mensajeMesa}.");
    }

    /**
     * 6. ACTUALIZACIÓN COMPLETA DE RESERVA (Modal / Panel de Edición)
     */
    public function update(Request $request, $id)
    {
        $reserva = reserva::findOrFail($id);

        $validados = $request->validate([
            'nombre' => 'required|string|min:3|max:100',
            'personas' => 'required|integer|min:1|max:30',
            'telefono' => 'required|string|max:20',
            'fecha_reserva' => 'required|date',
            'estado' => 'required|string|in:Pendiente,Confirmada,Cancelada,Completada',
            'mesa' => 'nullable|string|max:50',
            'notas' => 'nullable|string|max:500',
        ]);

        $reserva->update($validados);

        return redirect()->back()->with('success', "Reserva #{$id} ({$reserva->nombre}) actualizada exitosamente.");
    }

    /**
     * 7. ELIMINAR RESERVA
     */
    public function destroy($id)
    {
        $reserva = reserva::findOrFail($id);
        $cliente = $reserva->nombre;
        $reserva->delete();

        return redirect()->back()->with('success', "La reserva #{$id} de {$cliente} fue eliminada del sistema.");
    }
}
