@extends('layouts.app')

@section('titulo', 'Contáctanos y Ubicación')

@section('contenido')
    {{-- 🕒 LÓGICA DE HORARIOS EN TIEMPO REAL (Zona Horaria Perú) --}}
    @php
        $horaActual = now('America/Lima')->hour; // Número del 0 al 23
        $estaAbierto = ($horaActual >= 12 && $horaActual < 23); // Abierto de 12:00 a 23:00
    @endphp

    <div style="margin-bottom: 2rem; text-align: center;">
        <span style="font-size: 2.5rem;">📍</span>
        <h1 style="color: #f43f5e; font-size: 2rem; margin-top: 0.5rem; font-weight: 700;">Visítanos y Contáctanos</h1>
        <p style="color: #94a3b8; font-size: 1rem;">Te esperamos con la mejor sazón tradicional en un ambiente acogedor.</p>
    </div>

    {{-- 1. TARJETAS DE INFORMACIÓN RÁPIDA --}}
    <div
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 2rem; text-align: left;">

        {{-- TARJETA 1: DIRECCIÓN --}}
        <div
            style="background: rgba(255,255,255,0.03); padding: 1.2rem; border-radius: 1rem; border: 1px solid rgba(255,255,255,0.08);">
            <div style="font-size: 1.3rem; margin-bottom: 0.3rem;">📍 Dirección</div>
            <p style="color: #f8fafc; font-weight: 600; font-size: 0.95rem;">Av. La Marina 1234</p>
            <p style="color: #94a3b8; font-size: 0.85rem;">San Miguel, Lima - Perú</p>
        </div>

        {{-- TARJETA 2: HORARIO Y ESTADO EN VIVO (ABIERTO / CERRADO) --}}
        <div
            style="background: rgba(255,255,255,0.03); padding: 1.2rem; border-radius: 1rem; border: 1px solid rgba(255,255,255,0.08);">
            <div style="font-size: 1.3rem; margin-bottom: 0.3rem;">⏰ Horario de Atención</div>
            <p style="color: #f8fafc; font-weight: 600; font-size: 0.95rem;">Lunes a Domingo</p>
            <p style="color: #f59e0b; font-size: 0.85rem; font-weight: 500; margin-bottom: 0.5rem;">12:00 PM – 11:00 PM</p>

            @if($estaAbierto)
                <span
                    style="background: rgba(16, 185, 129, 0.2); color: #6ee7b7; border: 1px solid #10b981; padding: 0.25rem 0.65rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; display: inline-block;">
                    🟢 ABIERTO AHORA
                </span>
            @else
                <span
                    style="background: rgba(239, 68, 68, 0.2); color: #fca5a5; border: 1px solid #ef4444; padding: 0.25rem 0.65rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; display: inline-block;">
                    🔴 CERRADO AHORA
                </span>
            @endif
        </div>

        {{-- TARJETA 3: ATENCIÓN INMEDIATA --}}
        <div
            style="background: rgba(255,255,255,0.03); padding: 1.2rem; border-radius: 1rem; border: 1px solid rgba(255,255,255,0.08);">
            <div style="font-size: 1.3rem; margin-bottom: 0.3rem;">📱 WhatsApp Directo</div>
            <p style="color: #f8fafc; font-weight: 600; font-size: 0.95rem;">+51 987 654 321</p>
            <p style="color: #10b981; font-size: 0.85rem; font-weight: 600; margin-top: 0.3rem;">Pedidos y consultas
                directas</p>
        </div>

    </div>

    {{-- 2. MAPA INTERACTIVO DE GOOGLE MAPS --}}
    <div
        style="border-radius: 1.25rem; overflow: hidden; border: 1px solid rgba(255,255,255,0.15); box-shadow: 0 15px 30px rgba(0,0,0,0.4); margin-bottom: 1.5rem; background: #000;">
        <iframe
            src="https://maps.google.com/maps?q=Av.+La+Marina+1234,+San+Miguel,+Lima,+Peru&t=&z=15&ie=UTF8&iwloc=&output=embed"
            width="100%" height="320" style="border: 0; display: block;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>

    {{-- 3. BOTÓN DE CÓMO LLEGAR (GPS) --}}
    <div style="text-align: center;">
        <a href="https://maps.google.com/?q=Av.+La+Marina+1234,+San+Miguel,+Lima,+Peru" target="_blank"
            style="display: inline-block; background: #f43f5e; color: white; padding: 0.75rem 1.8rem; border-radius: 0.75rem; text-decoration: none; font-weight: 600; font-size: 0.95rem; box-shadow: 0 10px 20px -5px rgba(244, 63, 94, 0.4); transition: transform 0.2s;"
            onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            🚗 Abrir en Google Maps / Waze
        </a>
    </div>
@endsection