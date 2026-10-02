@extends('layouts.app')

@section('titulo', 'Nuestra Carta')

@section('contenido')
    <h1 style="color: #f43f5e; margin-bottom: 0.5rem; font-size: 2rem;">🍽️ Carta de "El Buen Sabor"</h1>
    <p style="color: #94a3b8; margin-bottom: 1.5rem;">Búsqueda interactiva en tiempo real con Livewire.</p>

    {{-- Componente Reactivo de Livewire --}}
    <livewire:buscar-platos />
@endsection