@extends('layouts.app')

@section('titulo', 'Bienvenidos')

@section('contenido')
    <div
        style="display: inline-block; background: linear-gradient(135deg, #ef4444, #f43f5e); color: white; padding: 0.35rem 1rem; border-radius: 9999px; font-weight: bold; font-size: 0.85rem; margin-bottom: 1.5rem;">
        🔥 EL MEJOR SABOR DE LA CIUDAD
    </div>

    <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem;">
        Restaurante "El Buen Sabor" 🍽️
    </h1>
    <p style="color: #94a3b8; font-size: 1.1rem; line-height: 1.6; margin-bottom: 2rem;">
        Comida tradicional preparada al momento con ingredientes 100% frescos y la mejor sazón.
    </p>

    <a href="/menu"
        style="display: inline-block; background: #ef4444; color: white; padding: 0.85rem 2rem; border-radius: 0.75rem; text-decoration: none; font-weight: 600; box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.4);">
        Ver la Carta de Platos ➔
    </a>
@endsection