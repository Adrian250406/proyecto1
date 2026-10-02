<?php

namespace App\Http\Controllers;

use App\Models\reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    /**
     * Muestra la lista de reservas (Panel Administrativo).
     */
    public function index()
    {
        $reservas = reserva::orderBy('fecha_reserva', 'desc')->get();
        return view('admin.reservas', compact('reservas'));
    }

    /**
     * Registra una nueva reserva desde la interfaz pública / PWA.
     */
    public function store(Request $request)
    {
        // 🕒 Hora exacta en Perú + 30 minutos mínimos de anticipación
        $minimoTiempo = now('America/Lima')->addMinutes(30);

        // 🛡️ REGLAS DE VALIDACIÓN ESTRICTAS
        $validados = $request->validate([
            // 1. NOMBRE: Solo letras y espacios, mínimo 3 letras
            'nombre' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            // 2. PERSONAS: Mínimo 1, máximo 20
            'personas' => 'required|integer|min:1|max:20',

            // 3. TELÉFONO PERÚ: Debe tener 9 dígitos y empezar obligatoriamente con el número 9
            'telefono' => [
                'required',
                'regex:/^9[0-9]{8}$/'
            ],

            // 4. FECHA: Al menos 30 minutos después de la hora actual en Perú
            'fecha_reserva' => [
                'required',
                'date',
                'after_or_equal:' . $minimoTiempo->toDateTimeString()
            ],
        ], [
            // 💬 MENSAJES CLAROS EN ESPAÑOL:
            'nombre.required'              => 'Por favor, ingresa tu nombre.',
            'nombre.min'                   => 'El nombre debe tener al menos 3 letras.',
            'nombre.regex'                 => 'El nombre solo puede contener letras y espacios (no números ni símbolos).',
            'personas.min'                 => 'La reserva mínima es para 1 persona.',
            'personas.max'                 => 'El aforo máximo por reserva web es de 20 personas.',
            'telefono.required'            => 'El teléfono celular es obligatorio.',
            'telefono.regex'               => 'El teléfono debe ser un celular de Perú válido (9 dígitos y empezar con 9).',
            'fecha_reserva.required'       => 'Debes seleccionar la fecha y hora de la reserva.',
            'fecha_reserva.after_or_equal' => 'Las reservas deben realizarse con al menos 30 minutos de anticipación respecto a la hora actual de Perú.',
        ]);

        $validados['estado'] = 'Pendiente';

        $reserva = reserva::create($validados);

        return redirect()->back()->with('success', "¡Mesa reservada exitosamente para {$reserva->nombre}! Tu código es #{$reserva->id}.");
    }

    /**
     * Actualiza el estado operativo de una reserva (Confirmada, Cancelada, Completada).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|string|in:Pendiente,Confirmada,Cancelada,Completada'
        ]);

        $reserva = reserva::findOrFail($id);
        $reserva->update(['estado' => $request->estado]);

        return redirect()->back()->with('success', "Reserva #{$id} actualizada a estado {$request->estado}.");
    }
}
