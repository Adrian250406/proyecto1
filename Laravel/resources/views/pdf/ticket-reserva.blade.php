<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ticket de Reserva #{{ $reserva->id }} - El Buen Sabor</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 20px;
            font-size: 13px;
        }

        .ticket-card {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 25px;
            max-width: 480px;
            margin: 0 auto;
            background: #ffffff;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .brand-title {
            font-size: 22px;
            font-weight: 800;
            color: #b91c1c;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .brand-subtitle {
            font-size: 11px;
            color: #64748b;
            margin-top: 4px;
        }

        .ticket-badge {
            display: inline-block;
            background: #fef2f2;
            color: #dc2626;
            font-weight: bold;
            font-size: 12px;
            padding: 4px 12px;
            border-radius: 20px;
            margin-top: 10px;
            border: 1px solid #fecaca;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .details-table td {
            padding: 8px 0;
            border-bottom: 1px solid #f8fafc;
        }

        .label {
            color: #64748b;
            font-weight: 600;
            width: 40%;
        }

        .value {
            color: #0f172a;
            font-weight: bold;
            text-align: right;
        }

        .instructions {
            background: #fffbeb;
            border: 1px solid #fef3c7;
            color: #92400e;
            padding: 12px;
            border-radius: 8px;
            font-size: 11px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .footer {
            text-align: center;
            border-top: 2px dashed #cbd5e1;
            padding-top: 15px;
            color: #94a3b8;
            font-size: 10px;
        }

        .barcode {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            letter-spacing: 4px;
            color: #0f172a;
            font-weight: bold;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="ticket-card">
        {{-- Encabezado del Restaurante --}}
        <div class="header">
            <h1 class="brand-title">EL BUEN SABOR</h1>
            <div class="brand-subtitle">Tradición Culinaria Criolla &bull; Miraflores, Lima - Perú</div>
            <div class="ticket-badge">TICKET DIGITAL DE RESERVA</div>
        </div>

        {{-- Tabla de Datos de la Reserva --}}
        <table class="details-table">
            <tr>
                <td class="label">Código de Reserva:</td>
                <td class="value">#{{ str_pad($reserva->id, 5, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td class="label">Titular de Mesa:</td>
                <td class="value">{{ $reserva->nombre }}</td>
            </tr>
            <tr>
                <td class="label">N° de Comensales:</td>
                <td class="value">{{ $reserva->personas }} Personas</td>
            </tr>
            <tr>
                <td class="label">Teléfono Celular:</td>
                <td class="value">+51 {{ $reserva->telefono }}</td>
            </tr>
            <tr>
                <td class="label">Fecha y Hora:</td>
                <td class="value">
                    {{ \Carbon\Carbon::parse($reserva->fecha_reserva)->locale('es')->isoFormat('dddd D [de] MMMM [a las] h:mm A') }}
                </td>
            </tr>
            <tr>
                <td class="label">Estado Actual:</td>
                <td class="value" style="color: #16a34a;">{{ $reserva->estado ?? 'Pendiente' }}</td>
            </tr>
        </table>

        {{-- Instrucciones de Llegada --}}
        @php
            $horaPactada = \Carbon\Carbon::parse($reserva->fecha_reserva);
            $horaLimite = $horaPactada->copy()->addMinutes(15)->format('h:i A');
        @endphp

        <div class="instructions">
            <strong>&bull; Términos y Tolerancia de Salón:</strong><br>
            Presente este ticket en recepción al llegar. Su mesa estará reservada estrictamente hasta las
            <strong>{{ $horaLimite }}</strong> (15 minutos de tolerancia respecto a su hora de las
            {{ $horaPactada->format('h:i A') }}).
        </div>


        {{-- Pie de Comprobante --}}
        <div class="footer">
            <div>SISTEMA DE GESTIÓN GASTRONÓMICA SIS-REST-01</div>
            <div class="barcode">*RES-{{ str_pad($reserva->id, 6, '0', STR_PAD_LEFT) }}*</div>
            <div style="margin-top: 4px;">Generado el {{ now('America/Lima')->format('d/m/Y H:i:s') }} (Hora Perú)</div>
        </div>
    </div>

</body>

</html>