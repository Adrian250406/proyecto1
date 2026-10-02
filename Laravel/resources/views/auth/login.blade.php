@extends('layouts.app')

@section('titulo', 'Acceso Administrador')

@section('contenido')
    <div style="text-align: center; margin-bottom: 2rem;">
        <span style="font-size: 2.5rem;">🔐</span>
        <h1 style="color: #f43f5e; font-size: 1.8rem; margin-top: 0.5rem;">Acceso de Administrador</h1>
        <p style="color: #94a3b8; font-size: 0.95rem;">Ingresa tus credenciales para gestionar el restaurante.</p>
    </div>

    {{-- ALERTA DE MENSAJES DE ERROR --}}
    @if($errors->any())
        <div
            style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #fca5a5; padding: 0.9rem; border-radius: 0.75rem; margin-bottom: 1.5rem; text-align: left; font-size: 0.9rem;">
            ⚠️ {{ $errors->first() }}
        </div>
    @endif

    {{-- ALERTA DE ÉXITO --}}
    @if(session('success'))
        <div
            style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #6ee7b7; padding: 0.9rem; border-radius: 0.75rem; margin-bottom: 1.5rem; text-align: center; font-size: 0.9rem;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST"
        style="display: flex; flex-direction: column; gap: 1.2rem; text-align: left;">
        @csrf

        {{-- 1. CORREO ELECTRÓNICO --}}
        <div>
            <label
                style="color: #cbd5e1; font-size: 0.9rem; font-weight: 600; display: block; margin-bottom: 0.4rem;">Correo
                Electrónico:</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="ejemplo@buensabor.pe" required
                autofocus
                style="width: 100%; padding: 0.8rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.3); color: white; outline: none;">
        </div>

        {{-- 2. CONTRASEÑA --}}
        <div>
            <label
                style="color: #cbd5e1; font-size: 0.9rem; font-weight: 600; display: block; margin-bottom: 0.4rem;">Contraseña:</label>
            <input type="password" name="password" placeholder="••••••••" required
                style="width: 100%; padding: 0.8rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.3); color: white; outline: none;">
        </div>

        <button type="submit"
            style="margin-top: 0.5rem; background: #f43f5e; color: white; border: none; padding: 0.9rem; border-radius: 0.5rem; font-weight: bold; font-size: 1rem; cursor: pointer; transition: background 0.2s;"
            onmouseover="this.style.background='#e11d48'" onmouseout="this.style.background='#f43f5e'">
            Iniciar Sesión ➔
        </button>
    </form>

    <div
        style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1); font-size: 0.8rem; color: #64748b; text-align: center;">
        🔑 <strong>Credencial de prueba:</strong> <code>admin@buensabor.pe</code> | Clave: <code>admin123</code>
    </div>
@endsection