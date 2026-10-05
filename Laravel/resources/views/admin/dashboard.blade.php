@extends('layouts.app')

@section('titulo', 'Dashboard Ejecutivo - El Buen Sabor')

@section('contenido')
    {{-- Encabezado del Dashboard --}}
    <div
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="color: #f43f5e; margin: 0; font-size: 2rem; font-weight: 800;">📊 Dashboard Ejecutivo</h1>
            <p style="color: #94a3b8; margin: 0.3rem 0 0 0; font-size: 0.95rem;">Analítica de demanda, aforo y estado
                operativo del restaurante.</p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('admin.productos.index') }}" wire:navigate
                style="background: rgba(245, 158, 11, 0.15); border: 1px solid #f59e0b; color: #fcd34d; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; font-weight: bold; font-size: 0.9rem;">
                🍔 Gestión de Platos
            </a>
            <a href="{{ route('admin.reservas.index') }}" wire:navigate
                style="background: rgba(244, 63, 94, 0.15); border: 1px solid #f43f5e; color: #fca5a5; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; font-weight: bold; font-size: 0.9rem;">
                📅 Gestión de Salón
            </a>
        </div>

    </div>

    {{-- 📈 1. TARJETAS KPI EJECUTIVAS --}}
    <div
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div
            style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.1); padding: 1.25rem; border-radius: 0.75rem; text-align: left;">
            <div style="color: #94a3b8; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Total Reservas
            </div>
            <div style="color: #ffffff; font-size: 1.8rem; font-weight: 800; margin-top: 0.3rem;">{{ $totalReservas }}</div>
            <div style="color: #38bdf8; font-size: 0.75rem; margin-top: 0.2rem;">📈 Acumulado histórico</div>
        </div>

        <div
            style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.1); padding: 1.25rem; border-radius: 0.75rem; text-align: left;">
            <div style="color: #94a3b8; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Aforo Atendido
            </div>
            <div style="color: #f59e0b; font-size: 1.8rem; font-weight: 800; margin-top: 0.3rem;">{{ $totalPersonas }}</div>
            <div style="color: #fcd34d; font-size: 0.75rem; margin-top: 0.2rem;">👥 Comensales totales</div>
        </div>

        <div
            style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(234, 179, 8, 0.3); padding: 1.25rem; border-radius: 0.75rem; text-align: left;">
            <div style="color: #fde047; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Pendientes</div>
            <div style="color: #fde047; font-size: 1.8rem; font-weight: 800; margin-top: 0.3rem;">{{ $pendientes }}</div>
            <div style="color: #fef08a; font-size: 0.75rem; margin-top: 0.2rem;">⏳ Por confirmar</div>
        </div>

        <div
            style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(16, 185, 129, 0.3); padding: 1.25rem; border-radius: 0.75rem; text-align: left;">
            <div style="color: #6ee7b7; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Confirmadas /
                Listas</div>
            <div style="color: #10b981; font-size: 1.8rem; font-weight: 800; margin-top: 0.3rem;">
                {{ $confirmadas + $completadas }}</div>
            <div style="color: #a7f3d0; font-size: 0.75rem; margin-top: 0.2rem;">✅ En salón o completadas</div>
        </div>
    </div>

    {{-- 📊 2. GRÁFICO DE DEMANDA (CHART.JS) --}}
    <div
        style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 2rem;">
        <h3 style="color: #ffffff; font-size: 1.1rem; margin: 0 0 1rem 0; font-weight: 700;">Distribución de Operaciones
        </h3>
        <div style="max-height: 250px; display: flex; justify-content: center;">
            <canvas id="dashboardChart" style="max-height: 240px;"></canvas>
        </div>
    </div>

    {{-- 📋 3. RESUMEN EJECUTIVO DE ÚLTIMAS 5 RESERVAS --}}
    <div
        style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0.75rem; padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 style="color: #ffffff; font-size: 1.1rem; margin: 0; font-weight: 700;">Últimas Actividades</h3>
            <a href="{{ route('admin.reservas.index') }}" wire:navigate
                style="color: #38bdf8; font-size: 0.85rem; text-decoration: none;">Ver todas &rarr;</a>
        </div>

        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1;">
                    <th style="padding: 0.6rem;">Código</th>
                    <th style="padding: 0.6rem;">Cliente</th>
                    <th style="padding: 0.6rem;">Personas</th>
                    <th style="padding: 0.6rem;">Fecha / Hora</th>
                    <th style="padding: 0.6rem;">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservasRecientes as $res)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 0.6rem; color: #94a3b8;">#{{ str_pad($res->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td style="padding: 0.6rem; font-weight: 600; color: #ffffff;">{{ $res->nombre }}</td>
                        <td style="padding: 0.6rem;">{{ $res->personas }} pax</td>
                        <td style="padding: 0.6rem; color: #94a3b8;">
                            {{ \Carbon\Carbon::parse($res->fecha_reserva)->format('d/m H:i') }}</td>
                        <td style="padding: 0.6rem;">
                            <span
                                style="font-size: 0.8rem; font-weight: bold; color: {{ $res->estado == 'Confirmada' ? '#6ee7b7' : ($res->estado == 'Cancelada' ? '#fca5a5' : '#fde047') }};">
                                {{ $res->estado }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 1.5rem; text-align: center; color: #64748b;">No hay actividades
                            recientes.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Script de Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('dashboardChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pendientes', 'Confirmadas', 'Completadas', 'Canceladas'],
                        datasets: [{
                            data: [{{ $pendientes }}, {{ $confirmadas }}, {{ $completadas }}, {{ $canceladas }}],
                            backgroundColor: ['#eab308', '#10b981', '#3b82f6', '#ef4444'],
                            borderColor: '#1e293b',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { color: '#cbd5e1', font: { size: 12 } }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection