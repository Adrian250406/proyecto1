@extends('layouts.app')

@section('titulo', 'Panel Administrativo - Gestión de Reservas')

@section('contenido')
    {{-- Encabezado con Botón de Acceso al Dashboard --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="color: #f43f5e; margin: 0; font-size: 1.8rem; font-weight: 800;">⚙️ Gestión de Reservas (Salón)</h1>
            <p style="color: #94a3b8; margin: 0.3rem 0 0 0; font-size: 0.95rem;">Administración y control operativo de mesas en tiempo real.</p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.dashboard') }}" wire:navigate style="background: rgba(56, 189, 248, 0.15); border: 1px solid #38bdf8; color: #7dd3fc; padding: 0.45rem 0.9rem; border-radius: 0.5rem; text-decoration: none; font-weight: bold; font-size: 0.85rem;">
                📊 Ver Dashboard & Métricas
            </a>
        </div>
    </div>

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #6ee7b7; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.2); color: #cbd5e1;">
                    <th style="padding: 0.75rem;">ID</th>
                    <th style="padding: 0.75rem;">Cliente</th>
                    <th style="padding: 0.75rem;">Personas</th>
                    <th style="padding: 0.75rem;">Teléfono</th>
                    <th style="padding: 0.75rem;">Fecha / Hora</th>
                    <th style="padding: 0.75rem;">Estado</th>
                    <th style="padding: 0.75rem; text-align: center;">Acciones & Ticket</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservas as $res)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.08);">
                        <td style="padding: 0.75rem; color: #94a3b8;">#{{ $res->id }}</td>
                        <td style="padding: 0.75rem; font-weight: 600; color: #ffffff;">{{ $res->nombre }}</td>
                        <td style="padding: 0.75rem;">{{ $res->personas }}</td>
                        <td style="padding: 0.75rem; color: #94a3b8;">{{ $res->telefono }}</td>
                        <td style="padding: 0.75rem;">{{ \Carbon\Carbon::parse($res->fecha_reserva)->format('d/m/Y H:i') }}</td>
                        <td style="padding: 0.75rem;">
                            @if($res->estado == 'Confirmada')
                                <span style="background: rgba(16,185,129,0.2); color: #6ee7b7; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.8rem; font-weight: bold;">Confirmada</span>
                            @elseif($res->estado == 'Cancelada')
                                <span style="background: rgba(239,68,68,0.2); color: #fca5a5; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.8rem; font-weight: bold;">Cancelada</span>
                            @elseif($res->estado == 'Completada')
                                <span style="background: rgba(59,130,246,0.2); color: #93c5fd; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.8rem; font-weight: bold;">Completada</span>
                            @else
                                <span style="background: rgba(234,179,8,0.2); color: #fde047; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.8rem; font-weight: bold;">Pendiente</span>
                            @endif
                        </td>
                        <td style="padding: 0.75rem; text-align: center;">
                            <div style="display: flex; gap: 0.4rem; justify-content: center; align-items: center;">
                                {{-- Formulario para cambiar estado --}}
                                <form action="{{ route('admin.reservas.updateStatus', $res->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('PUT')
                                    <select name="estado" onchange="this.form.submit()" style="background: rgba(0,0,0,0.4); color: white; border: 1px solid rgba(255,255,255,0.2); border-radius: 0.35rem; padding: 0.3rem; font-size: 0.8rem; outline: none; cursor: pointer;">
                                        <option value="" disabled selected>Cambiar...</option>
                                        <option value="Confirmada">Confirmar</option>
                                        <option value="Completada">Completar</option>
                                        <option value="Cancelada">Cancelar</option>
                                    </select>
                                </form>

                                {{-- Botón para ver/descargar el comprobante PDF --}}
                                <a href="{{ route('reservas.pdf', $res->id) }}" target="_blank" title="Ver / Descargar Ticket PDF" style="background: rgba(255,255,255,0.1); color: #cbd5e1; padding: 0.3rem 0.6rem; border-radius: 0.35rem; text-decoration: none; font-size: 0.8rem; border: 1px solid rgba(255,255,255,0.15); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                                    📄 PDF
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 2.5rem; text-align: center; color: #64748b;">
                            No hay reservas registradas en el sistema actualmente.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
