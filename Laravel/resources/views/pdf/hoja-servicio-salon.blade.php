<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hoja de Servicio de Salón - El Buen Sabor</title>
    <style>
        @page {
            margin: 1.2cm 1.5cm;
            size: A4 portrait;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.4;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #e11d48;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .brand-title {
            font-size: 20px;
            font-weight: 800;
            color: #991b1b;
            margin: 0;
            letter-spacing: 1px;
        }
        .brand-sub {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }
        .report-badge {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 6px 12px;
            border-radius: 6px;
            text-align: right;
            font-size: 10px;
        }
        .kpi-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: separate;
            border-spacing: 6px 0;
        }
        .kpi-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px;
            text-align: center;
        }
        .kpi-num {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
            margin-top: 2px;
        }
        .kpi-lbl {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.5px;
        }
        .service-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .service-table th {
            background: #0f172a;
            color: #ffffff;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 6px 8px;
            text-align: left;
            border: 1px solid #0f172a;
        }
        .service-table td {
            padding: 6px 8px;
            border: 1px solid #e2e8f0;
            font-size: 10px;
        }
        .service-table tr:nth-child(even) {
            background: #f8fafc;
        }
        .checkbox-box {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1.5px solid #64748b;
            border-radius: 2px;
            text-align: center;
            vertical-align: middle;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-confirmada { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .badge-pendiente { background: #fef9c3; color: #854d0e; border: 1px solid #fde047; }
        .badge-completada { background: #e0f2fe; color: #0369a1; border: 1px solid #7dd3fc; }
        .badge-cancelada { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
        
        .badge-mesa {
            background: #f1f5f9;
            color: #0f172a;
            font-weight: 700;
            border: 1px solid #cbd5e1;
            padding: 2px 5px;
            border-radius: 4px;
        }
        .footer {
            margin-top: 20px;
            border-top: 1px solid #cbd5e1;
            padding-top: 6px;
            font-size: 8px;
            color: #64748b;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Encabezado -->
    <table class="header-table">
        <tr>
            <td style="width: 60%;">
                <h1 class="brand-title">EL BUEN SABOR</h1>
                <div class="brand-sub">Sistema de Gestión Gastronómica &bull; Hoja Operativa de Salón</div>
            </td>
            <td style="width: 40%; vertical-align: middle;">
                <div class="report-badge">
                    <strong>TURNO:</strong> {{ $tituloFecha }}<br>
                    <span style="color: #64748b;">Emitido: {{ $hoy->format('d/m/Y H:i') }} (Hora Perú)</span>
                </div>
            </td>
        </tr>
    </table>

    <!-- Tarjetas de Resumen KPI -->
    <table class="kpi-table">
        <tr>
            <td class="kpi-box" style="width: 25%;">
                <div class="kpi-lbl">Total Reservas</div>
                <div class="kpi-num">{{ $metricas['total_reservas'] }}</div>
            </td>
            <td class="kpi-box" style="width: 25%;">
                <div class="kpi-lbl">Comensales Totales</div>
                <div class="kpi-num" style="color: #0284c7;">{{ $metricas['total_comensales'] }} Pax</div>
            </td>
            <td class="kpi-box" style="width: 25%;">
                <div class="kpi-lbl">Mesas Asignadas</div>
                <div class="kpi-num" style="color: #16a34a;">{{ $metricas['mesas_asignadas'] }}</div>
            </td>
            <td class="kpi-box" style="width: 25%;">
                <div class="kpi-lbl">Distribución Áreas</div>
                <div style="font-size: 9px; margin-top: 3px; font-weight: 600;">
                    Salón: {{ $metricas['salon_principal'] }} | Terraza: {{ $metricas['terraza'] }} | VIP: {{ $metricas['vip'] }}
                </div>
            </td>
        </tr>
    </table>

    <!-- Tabla Operativa de Llegada de Comensales -->
    <table class="service-table">
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">Check</th>
                <th style="width: 8%;">Hora</th>
                <th style="width: 8%;">ID</th>
                <th style="width: 24%;">Titular / Cliente</th>
                <th style="width: 6%; text-align: center;">Pax</th>
                <th style="width: 14%;">Teléfono</th>
                <th style="width: 13%;">Mesa</th>
                <th style="width: 10%;">Estado</th>
                <th style="width: 12%;">Notas Especiales</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservas as $res)
                <tr>
                    <td style="text-align: center;">
                        <span class="checkbox-box"></span>
                    </td>
                    <td style="font-weight: 800; color: #0f172a;">
                        {{ \Carbon\Carbon::parse($res->fecha_reserva)->format('h:i A') }}
                    </td>
                    <td style="color: #64748b; font-weight: bold;">
                        #{{ $res->id }}
                    </td>
                    <td>
                        <strong style="color: #0f172a;">{{ $res->nombre }}</strong>
                    </td>
                    <td style="text-align: center; font-weight: 800;">
                        {{ $res->personas }}
                    </td>
                    <td style="color: #475569;">
                        +51 {{ $res->telefono }}
                    </td>
                    <td>
                        @if(!empty($res->mesa))
                            <span class="badge-mesa">{{ $res->mesa }}</span>
                        @else
                            <span style="color: #94a3b8; font-style: italic;">Sin asignar</span>
                        @endif
                    </td>
                    <td>
                        @if($res->estado === 'Confirmada')
                            <span class="badge badge-confirmada">Confirmada</span>
                        @elseif($res->estado === 'Cancelada')
                            <span class="badge badge-cancelada">Cancelada</span>
                        @elseif($res->estado === 'Completada')
                            <span class="badge badge-completada">Completada</span>
                        @else
                            <span class="badge badge-pendiente">Pendiente</span>
                        @endif
                    </td>
                    <td style="font-size: 8.5px; color: #64748b;">
                        {{ $res->notas ? Str::limit($res->notas, 40) : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 25px; color: #64748b;">
                        No hay reservas programadas para este turno o fecha seleccionada.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pie de Reporte -->
    <div class="footer">
        Documento oficial de control de salón &bull; Restaurante El Buen Sabor &bull; Generado por Plataforma SIS-REST-01
    </div>

</body>
</html>
