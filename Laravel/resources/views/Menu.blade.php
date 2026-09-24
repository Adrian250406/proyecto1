<!-- Le decimos que use el molde maestro -->
@extends('layouts.app')

<!-- Definimos el título de la pestaña del navegador -->
@section('titulo', 'Nuestra Carta')

<!-- Metemos el contenido específico del Menú -->
@section('contenido')
    <h1 style="font-size: 2rem; margin-bottom: 1rem;">🍔 Carta del Restaurante</h1>
    <p style="color: #94a3b8; margin-bottom: 1.5rem;">Platos disponibles hoy:</p>

    <div
        style="background: rgba(255,255,255,0.03); padding: 1.2rem; border-radius: 0.8rem; border: 1px dashed rgba(255,255,255,0.2); line-height: 2.2;">
        <p>🍕 Pizza Artesanal - <strong style="color: #f43f5e;">S/ 25.00</strong></p>
        <p>🍔 Hamburguesa Clásica - <strong style="color: #f43f5e;">S/ 18.00</strong></p>
        <p>🥤 Gaseosa Helada - <strong style="color: #f43f5e;">S/ 5.00</strong></p>
    </div>
@endsection