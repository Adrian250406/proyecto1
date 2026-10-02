@extends('layouts.app')

@section('titulo', 'Reserva tu Mesa')

@section('contenido')
    <h1 style="color: #f43f5e; margin-bottom: 0.5rem; font-size: 2rem;">📅 Reserva tu Mesa</h1>
    <p style="color: #94a3b8; margin-bottom: 1.5rem;">Asegura tu lugar en El Buen Sabor de forma rápida.</p>

    {{-- 🟢 ALERTA DE ÉXITO (Muestra el número de ticket generado) --}}
    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #6ee7b7; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; text-align: center; font-weight: 500;">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- 🔴 ALERTA DE ERRORES DE VALIDACIÓN (Muestra los mensajes claros en español) --}}
    @if($errors->any())
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #fca5a5; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; text-align: left;">
            <p style="font-weight: bold; margin-bottom: 0.5rem;">⚠️ Corrige los siguientes datos:</p>
            <ul style="padding-left: 1.2rem; font-size: 0.9rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reservas.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.2rem; text-align: left;">
        @csrf

        {{-- 1. CAMPO NOMBRE: Solo letras, espacios y mínimo 3 caracteres --}}
        <div>
            <label style="color: #cbd5e1; font-size: 0.9rem; font-weight: 600; display: block; margin-bottom: 0.3rem;">Nombre Completo:</label>
            <input type="text" 
                   name="nombre" 
                   value="{{ old('nombre') }}" 
                   placeholder="Ej: Adrián Jara" 
                   required 
                   pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+"
                   minlength="3"
                   maxlength="100"
                   title="Solo se permiten letras y espacios (mínimo 3 letras)"
                   style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.25); color: white; outline: none;">
        </div>

        {{-- 2. CAMPO PERSONAS: Mínimo 1, Máximo 20 --}}
        <div>
            <label style="color: #cbd5e1; font-size: 0.9rem; font-weight: 600; display: block; margin-bottom: 0.3rem;">Cantidad de Personas (1 a 20):</label>
            <input type="number" 
                   name="personas" 
                   value="{{ old('personas', 2) }}" 
                   min="1" 
                   max="20" 
                   required 
                   title="El aforo permitido por reserva web es de 1 a 20 personas"
                   style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.25); color: white; outline: none;">
        </div>

        {{-- 3. CAMPO TELÉFONO: Solo celulares de Perú (9 dígitos, empieza con 9) --}}
        <div>
            <label style="color: #cbd5e1; font-size: 0.9rem; font-weight: 600; display: block; margin-bottom: 0.3rem;">Teléfono Celular (Perú - 9 dígitos):</label>
            <input type="tel" 
                   name="telefono" 
                   value="{{ old('telefono') }}" 
                   placeholder="Ej: 987654321" 
                   required 
                   pattern="9[0-9]{8}"
                   maxlength="9"
                   title="Debe ser un número celular de Perú válido (9 dígitos y empezar con 9)"
                   style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.25); color: white; outline: none;">
        </div>

        {{-- 4. CAMPO FECHA Y HORA: Sincronizado con hora de Perú + 30 minutos mínimos de anticipación --}}
        <div>
            <label style="color: #cbd5e1; font-size: 0.9rem; font-weight: 600; display: block; margin-bottom: 0.3rem;">Fecha y Hora de la Reserva (mínimo 30 min de anticipación):</label>
            <input type="datetime-local" 
                   name="fecha_reserva" 
                   value="{{ old('fecha_reserva') }}" 
                   min="{{ now('America/Lima')->addMinutes(30)->format('Y-m-d\TH:i') }}" 
                   required 
                   title="Debes reservar con al menos 30 minutos de anticipación"
                   style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.25); color: white; outline: none;">
        </div>

        <button type="submit" 
                style="margin-top: 0.5rem; background: #f43f5e; color: white; border: none; padding: 0.85rem; border-radius: 0.5rem; font-weight: bold; cursor: pointer; transition: background 0.2s;" 
                onmouseover="this.style.background='#e11d48'" 
                onmouseout="this.style.background='#f43f5e'">
            Confirmar Reserva
        </button>
    </form>
@endsection