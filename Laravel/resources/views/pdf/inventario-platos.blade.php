<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario de Carta - El Buen Sabor</title>
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
            font-size: 15px;
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
        .inventory-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .inventory-table th {
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
        .inventory-table td {
            padding: 6px 8px;
            border: 1px solid #e2e8f0;
            font-size: 10px;
        }
        .inventory-table tr:nth-child(even) {
            background: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-disponible { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .badge-agotado { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
        
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
                <div class="brand-sub">Sistema de Gestión Gastronómica &bull; Balance de Inventario de Cocina</div>
            </td>
            <td style="width: 40%; vertical-align: middle;">
                <div class="report-badge">
                    <strong>REPORTE DE CARTA & COCINA</strong><br>
                    <span style="color: #64748b;">Emitido: {{ $ahora->format('d/m/Y H:i:s') }} (Hora Perú)</span>
                </div>
            </td>
        </tr>
    </table>

    <!-- Tarjetas de Resumen KPI -->
    <table class="kpi-table">
        <tr>
            <td class="kpi-box" style="width: 20%;">
                <div class="kpi-lbl">Total Platos</div>
                <div class="kpi-num">{{ $metricas['total_platos'] }}</div>
            </td>
            <td class="kpi-box" style="width: 20%;">
                <div class="kpi-lbl">Platos Activos</div>
                <div class="kpi-num" style="color: #16a34a;">{{ $metricas['platos_disponibles'] }}</div>
            </td>
            <td class="kpi-box" style="width: 20%;">
                <div class="kpi-lbl">Platos Agotados</div>
                <div class="kpi-num" style="color: #dc2626;">{{ $metricas['platos_agotados'] }}</div>
            </td>
            <td class="kpi-box" style="width: 20%;">
                <div class="kpi-lbl">Porciones Totales</div>
                <div class="kpi-num" style="color: #0284c7;">{{ $metricas['total_porciones'] }} Und</div>
            </td>
            <td class="kpi-box" style="width: 20%;">
                <div class="kpi-lbl">Valor Estimado</div>
                <div class="kpi-num" style="color: #d97706;">S/ {{ number_format($metricas['valor_carta'], 2) }}</div>
            </td>
        </tr>
    </table>

    <!-- Tabla de Inventario de Platos -->
    <table class="inventory-table">
        <thead>
            <tr>
                <th style="width: 8%;">ID</th>
                <th style="width: 32%;">Nombre del Plato Criollo</th>
                <th style="width: 15%; text-align: right;">Precio Carta</th>
                <th style="width: 15%; text-align: center;">Porciones en Cocina</th>
                <th style="width: 15%; text-align: right;">Valor Total</th>
                <th style="width: 15%; text-align: center;">Disponibilidad</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $p)
                <tr>
                    <td style="color: #64748b; font-weight: bold;">#{{ $p->id }}</td>
                    <td>
                        <strong style="color: #0f172a; font-size: 10.5px;">{{ $p->nombre }}</strong>
                        <div style="font-size: 8px; color: #64748b;">{{ Str::limit($p->descripcion, 55) }}</div>
                    </td>
                    <td style="text-align: right; font-weight: 700; color: #0f172a;">
                        S/ {{ number_format($p->precio, 2) }}
                    </td>
                    <td style="text-align: center; font-weight: 800; font-size: 11px; color: {{ $p->stock > 0 ? '#16a34a' : '#dc2626' }};">
                        {{ $p->stock }}
                    </td>
                    <td style="text-align: right; font-weight: 600; color: #475569;">
                        S/ {{ number_format($p->precio * $p->stock, 2) }}
                    </td>
                    <td style="text-align: center;">
                        @if($p->stock > 0)
                            <span class="badge badge-disponible">Disponible</span>
                        @else
                            <span class="badge badge-agotado">Agotado</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 25px; color: #64748b;">
                        No hay productos registrados en la carta gastronómica.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pie de Reporte -->
    <div class="footer">
        Documento oficial de control de cocina e inventario &bull; Restaurante El Buen Sabor &bull; Generado por Plataforma SIS-REST-01
    </div>

</body>
</html>
