<!-- Le decimos que use el mismo molde maestro -->
@extends('layouts.app')

<!-- Título para la pestaña del navegador -->
@section('titulo', 'Contáctanos')

<!-- Contenido específico de Contacto -->
@section('contenido')
    <h1 style="font-size: 2rem; margin-bottom: 1rem;">📞 Contáctanos</h1>
    <p style="color: #94a3b8; margin-bottom: 1.5rem;">¿Tienes un pedido o reservación?</p>

    <div
        style="background: rgba(255,255,255,0.03); padding: 1.2rem; border-radius: 0.8rem; border: 1px dashed rgba(255,255,255,0.2); line-height: 2.2;">
        <p>📍 Dirección: Av. Principal #123</p>
        <p>📱 WhatsApp: +51 987 654 321</p>
        <p>⏰ Horario: 12:00 PM - 11:00 PM</p>
    </div>
@endsection