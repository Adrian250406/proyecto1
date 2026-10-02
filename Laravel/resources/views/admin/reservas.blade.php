@extends('layouts.app')

@section('titulo', 'Panel Administrativo - Gestión de Reservas')

@section('contenido')
    <h1 style="color: #f43f5e; margin-bottom: 0.5rem; font-size: 1.8rem;">⚙️ Gestión de Reservas (Salón)</h1>
    <p style="color: #94a3b8; margin-bottom: 1.5rem;">Administración en tiempo real de mesas y confirmaciones.</p>

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
                    <th style="padding: 0.75rem; text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservas as $res)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.08);">
                        <td style="padding: 0.75rem; color: #94a3b8;">#{{ $res->id }}</td>
                        <td style="padding: 0.75rem; font-weight: 600;">{{ $res->nombre }}</td>
                        <td style="padding: 0.75rem;">{{ $res->personas }}</td>
                        <td style="padding: 0.75rem; color: #94a3b8;">{{ $res->telefono }}</td>
                        <td style="padding: 0.75rem;">{{ \Carbon\Carbon::parse($res->fecha_reserva)->format('d/m/Y H:i') }}</td>
                        <td style="padding: 0.75rem;">
                            @if($res->estado == 'Confirmada')
                                <span style="background: rgba(16,185,129,0.2); color: #6ee7b7; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.8rem;">Confirmada</span>
                            @elseif($res->estado == 'Cancelada')
                                <span style="background: rgba(239,68,68,0.2); color: #fca5a5; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.8rem;">Cancelada</span>
                            @elseif($res->estado == 'Completada')
                                <span style="background: rgba(59,130,246,0.2); color: #93c5fd; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.8rem;">Completada</span>
                            @else
                                <span style="background: rgba(234,179,8,0.2); color: #fde047; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.8rem;">Pendiente</span>
                            @endif
                        </td>
                        <td style="padding: 0.75rem; text-align: center;">
                            <form action="{{ route('admin.reservas.updateStatus', $res->id) }}" method="POST" style="display: inline-flex; gap: 0.3rem;">
                                @csrf
                                @method('PUT')
                                <select name="estado" onchange="this.form.submit()" style="background: rgba(0,0,0,0.4); color: white; border: 1px solid rgba(255,255,255,0.2); border-radius: 0.3rem; padding: 0.25rem; font-size: 0.8rem;">
                                    <option value="" disabled selected>Cambiar...</option>
                                    <option value="Confirmada">Confirmar</option>
                                    <option value="Completada">Completar</option>
                                    <option value="Cancelada">Cancelar</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 2rem; text-align: center; color: #64748b;">
                            No hay reservas registradas en el sistema actualmente.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
