@extends('layouts.app')

@section('titulo', 'Reservar Mesa')

@section('contenido')
    <h1 style="font-size: 2rem; margin-bottom: 1rem;">📅 Reservar una Mesa</h1>
    <p style="color: #94a3b8; margin-bottom: 1.5rem;">Completa tus datos para separar tu mesa:</p>

    <form style="display: flex; flex-direction: column; gap: 1rem; text-align: left; max-width: 400px; margin: 0 auto;">
        <div>
            <label style="color: #cbd5e1; font-size: 0.9rem;">Tu Nombre:</label>
            <input type="text" placeholder="Ej: Adrián"
                style="width: 100%; padding: 0.6rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.3); color: white; margin-top: 0.3rem;">
        </div>
        <div>
            <label style="color: #cbd5e1; font-size: 0.9rem;">Número de Personas:</label>
            <input type="number" placeholder="2"
                style="width: 100%; padding: 0.6rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.3); color: white; margin-top: 0.3rem;">
        </div>
        <button type="button"
            style="background: #ef4444; color: white; padding: 0.75rem; border-radius: 0.5rem; border: none; font-weight: bold; cursor: pointer; margin-top: 0.5rem;">
            Confirmar Reserva
        </button>
    </form>
@endsection