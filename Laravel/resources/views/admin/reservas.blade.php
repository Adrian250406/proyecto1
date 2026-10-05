@extends('layouts.app')

@section('titulo', 'Gestión de Salón y Reservas')

@section('contenido')
<div style="width: 100%; padding: 0.5rem 0;">

    <!-- 1. ENCABEZADO Y ACCIONES RÁPIDAS -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 1rem;">
        <div>
            <h1 style="color: #f43f5e; margin: 0; font-size: 1.8rem; font-weight: 800; display: flex; align-items: center; gap: 0.5rem;">
                <span>⚙️</span> Gestión de Salón & Mesas
            </h1>
            <p style="color: #94a3b8; margin: 0.3rem 0 0 0; font-size: 0.95rem;">
                Control de aforo en tiempo real, asignación de mesas y monitoreo de tolerancia (15 min).
            </p>
        </div>
        <div style="display: flex; gap: 0.6rem; align-items: center; flex-wrap: wrap;">
            <a href="{{ route('admin.reservas.exportCsv', ['fecha' => $filtroFecha ?? 'todas', 'estado' => $filtroEstado ?? '']) }}" 
               title="Descargar lista de reservas en formato CSV / Excel"
               style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #6ee7b7; padding: 0.5rem 0.9rem; border-radius: 0.75rem; text-decoration: none; font-weight: 700; font-size: 0.82rem; display: flex; align-items: center; gap: 0.4rem; transition: all 0.2s;">
                <span>📥</span> Exportar CSV
            </a>
            <a href="{{ route('admin.reservas.hojaServicioPdf', ['fecha' => $filtroFecha ?? 'hoy']) }}" target="_blank"
               title="Generar e imprimir hoja física de servicio para metre y mozos"
               style="background: rgba(168, 85, 247, 0.15); border: 1px solid #a855f7; color: #d8b4fe; padding: 0.5rem 0.9rem; border-radius: 0.75rem; text-decoration: none; font-weight: 700; font-size: 0.82rem; display: flex; align-items: center; gap: 0.4rem; transition: all 0.2s;">
                <span>🖨️</span> Hoja Servicio PDF
            </a>
            <a href="{{ route('admin.dashboard') }}" wire:navigate 
               style="background: rgba(56, 189, 248, 0.12); border: 1px solid #38bdf8; color: #7dd3fc; padding: 0.5rem 0.9rem; border-radius: 0.75rem; text-decoration: none; font-weight: 700; font-size: 0.82rem; display: flex; align-items: center; gap: 0.4rem; transition: all 0.2s;">
                <span>📊</span> Dashboard
            </a>
            <a href="{{ route('admin.productos.index') }}" wire:navigate 
               style="background: rgba(245, 158, 11, 0.12); border: 1px solid #f59e0b; color: #fbbf24; padding: 0.5rem 0.9rem; border-radius: 0.75rem; text-decoration: none; font-weight: 700; font-size: 0.82rem; display: flex; align-items: center; gap: 0.4rem; transition: all 0.2s;">
                <span>🍔</span> Platos
            </a>
        </div>
    </div>

    <!-- 2. TARJETAS DE MÉTRICAS / KPIS DE SALÓN -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
        <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 1rem; padding: 1rem; text-align: center;">
            <span style="font-size: 1.6rem; display: block; margin-bottom: 0.2rem;">📅</span>
            <span style="color: #94a3b8; font-size: 0.8rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em;">Reservas Hoy</span>
            <h3 style="color: #ffffff; font-size: 1.8rem; font-weight: 800; margin: 0.2rem 0 0 0;">{{ $metricas['total_hoy'] }}</h3>
        </div>

        <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 1rem; padding: 1rem; text-align: center;">
            <span style="font-size: 1.6rem; display: block; margin-bottom: 0.2rem;">👥</span>
            <span style="color: #94a3b8; font-size: 0.8rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em;">Comensales Hoy</span>
            <h3 style="color: #38bdf8; font-size: 1.8rem; font-weight: 800; margin: 0.2rem 0 0 0;">{{ $metricas['comensales_hoy'] }}</h3>
        </div>

        <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 1rem; padding: 1rem; text-align: center;">
            <span style="font-size: 1.6rem; display: block; margin-bottom: 0.2rem;">🪑</span>
            <span style="color: #94a3b8; font-size: 0.8rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em;">Mesas Asignadas</span>
            <h3 style="color: #34d399; font-size: 1.8rem; font-weight: 800; margin: 0.2rem 0 0 0;">{{ $metricas['mesas_asignadas'] }}</h3>
        </div>

        <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 1rem; padding: 1rem; text-align: center;">
            <span style="font-size: 1.6rem; display: block; margin-bottom: 0.2rem;">⏳</span>
            <span style="color: #94a3b8; font-size: 0.8rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em;">Por Confirmar</span>
            <h3 style="color: #facc15; font-size: 1.8rem; font-weight: 800; margin: 0.2rem 0 0 0;">{{ $metricas['pendientes'] }}</h3>
        </div>
    </div>

    <!-- 3. MENSAJES FLASH -->
    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #6ee7b7; padding: 0.85rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem;">
            <span>✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- 4. BARRA DE BÚSQUEDA Y FILTROS -->
    <div style="background: rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.08); border-radius: 1rem; padding: 1rem; margin-bottom: 1.5rem;">
        <form action="{{ route('admin.reservas.index') }}" method="GET" style="display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center;">
            
            <!-- Campo de Texto -->
            <div style="flex: 1; min-width: 220px; position: relative;">
                <input type="text" name="buscar" value="{{ $buscar ?? '' }}" 
                       placeholder="🔍 Buscar cliente, teléfono, mesa o notas..." 
                       style="width: 100%; background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.15); color: #fff; padding: 0.6rem 1rem; border-radius: 0.6rem; font-size: 0.85rem; outline: none;">
            </div>

            <!-- Filtro Estado -->
            <div>
                <select name="estado" style="background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.15); color: #fff; padding: 0.6rem 0.85rem; border-radius: 0.6rem; font-size: 0.85rem; outline: none; cursor: pointer;">
                    <option value="">Todos los Estados</option>
                    <option value="Pendiente" {{ ($filtroEstado ?? '') === 'Pendiente' ? 'selected' : '' }}>⏳ Pendiente</option>
                    <option value="Confirmada" {{ ($filtroEstado ?? '') === 'Confirmada' ? 'selected' : '' }}>✅ Confirmada</option>
                    <option value="Completada" {{ ($filtroEstado ?? '') === 'Completada' ? 'selected' : '' }}>🎉 Completada</option>
                    <option value="Cancelada" {{ ($filtroEstado ?? '') === 'Cancelada' ? 'selected' : '' }}>❌ Cancelada</option>
                </select>
            </div>

            <!-- Filtro Fecha -->
            <div>
                <select name="fecha" style="background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.15); color: #fff; padding: 0.6rem 0.85rem; border-radius: 0.6rem; font-size: 0.85rem; outline: none; cursor: pointer;">
                    <option value="todas" {{ ($filtroFecha ?? '') === 'todas' ? 'selected' : '' }}>📅 Todas las Fechas</option>
                    <option value="hoy" {{ ($filtroFecha ?? '') === 'hoy' ? 'selected' : '' }}>🔥 Solo Hoy</option>
                    <option value="manana" {{ ($filtroFecha ?? '') === 'manana' ? 'selected' : '' }}>☀️ Mañana</option>
                    <option value="semana" {{ ($filtroFecha ?? '') === 'semana' ? 'selected' : '' }}>📆 Próximos 7 días</option>
                </select>
            </div>

            <!-- Botones -->
            <button type="submit" style="background: #e11d48; color: white; border: none; padding: 0.6rem 1.25rem; border-radius: 0.6rem; font-size: 0.85rem; font-weight: 700; cursor: pointer; transition: background 0.2s;">
                Filtrar
            </button>

            @if(!empty($buscar) || !empty($filtroEstado) || ($filtroFecha ?? 'todas') !== 'todas')
                <a href="{{ route('admin.reservas.index') }}" style="background: rgba(255,255,255,0.08); color: #cbd5e1; border: 1px solid rgba(255,255,255,0.1); padding: 0.6rem 1rem; border-radius: 0.6rem; font-size: 0.85rem; text-decoration: none;">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    <!-- 5. TABLA MAESTRA DE RESERVAS Y SALÓN -->
    <div style="overflow-x: auto; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.08); border-radius: 1rem;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.15); background: rgba(0,0,0,0.3); color: #cbd5e1;">
                    <th style="padding: 0.85rem 1rem;">ID</th>
                    <th style="padding: 0.85rem 1rem;">Cliente & Contacto</th>
                    <th style="padding: 0.85rem 1rem; text-align: center;">Pax</th>
                    <th style="padding: 0.85rem 1rem;">Fecha, Hora & Tolerancia</th>
                    <th style="padding: 0.85rem 1rem;">Mesa Asignada</th>
                    <th style="padding: 0.85rem 1rem;">Estado Operativo</th>
                    <th style="padding: 0.85rem 1rem; text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $ahoraLima = \Carbon\Carbon::now('America/Lima');
                @endphp

                @forelse($reservas as $res)
                    @php
                        $fechaRes = \Carbon\Carbon::parse($res->fecha_reserva);
                        $minutosTranscurridos = $fechaRes->diffInMinutes($ahoraLima, false);
                        $toleranciaVencida = ($res->estado === 'Pendiente' && $minutosTranscurridos > 15);
                        $enTolerancia = ($res->estado === 'Pendiente' && $minutosTranscurridos >= 0 && $minutosTranscurridos <= 15);
                    @endphp

                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); {{ $toleranciaVencida ? 'background: rgba(239, 68, 68, 0.05);' : '' }} transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.03)'" onmouseout="this.style.background='{{ $toleranciaVencida ? 'rgba(239, 68, 68, 0.05)' : 'transparent' }}'">
                        
                        <!-- ID -->
                        <td style="padding: 0.85rem 1rem; color: #94a3b8; font-weight: 700;">#{{ $res->id }}</td>

                        <!-- Cliente y Celular con WhatsApp -->
                        <td style="padding: 0.85rem 1rem;">
                            <div style="font-weight: 700; color: #ffffff; font-size: 0.95rem;">{{ $res->nombre }}</div>
                            <div style="display: flex; align-items: center; gap: 0.4rem; margin-top: 0.2rem;">
                                <span style="color: #94a3b8; font-size: 0.8rem;">📱 {{ $res->telefono }}</span>
                                @if(!empty($res->telefono))
                                    <a href="https://wa.me/51{{ preg_replace('/[^0-9]/', '', $res->telefono) }}?text=Hola%20{{ urlencode($res->nombre) }},%20te%20saludamos%20del%20Restaurante%20El%20Buen%20Sabor%20sobre%20tu%20reserva%20%23{{ $res->id }}." 
                                       target="_blank" title="Escribir al WhatsApp del cliente"
                                       style="color: #34d399; font-size: 0.75rem; text-decoration: none; background: rgba(52, 211, 153, 0.1); padding: 0.1rem 0.4rem; border-radius: 0.3rem;">
                                        WhatsApp
                                    </a>
                                @endif
                            </div>
                            @if(!empty($res->notas))
                                <div style="color: #facc15; font-size: 0.75rem; margin-top: 0.3rem; background: rgba(250, 204, 21, 0.08); padding: 0.2rem 0.5rem; border-radius: 0.3rem; border: 1px solid rgba(250, 204, 21, 0.2);">
                                    💬 <em>{{ $res->notas }}</em>
                                </div>
                            @endif
                        </td>

                        <!-- Personas -->
                        <td style="padding: 0.85rem 1rem; text-align: center;">
                            <span style="background: rgba(255,255,255,0.08); color: #fff; padding: 0.25rem 0.6rem; border-radius: 0.5rem; font-weight: 800; font-size: 0.85rem;">
                                👥 {{ $res->personas }}
                            </span>
                        </td>

                        <!-- Fecha / Hora & Monitoreo de Tolerancia -->
                        <td style="padding: 0.85rem 1rem;">
                            <div style="color: #ffffff; font-weight: 600;">
                                {{ $fechaRes->format('d/m/Y') }}
                            </div>
                            <div style="color: #38bdf8; font-size: 0.8rem; font-weight: 700;">
                                🕒 {{ $fechaRes->format('h:i A') }}
                            </div>

                            <!-- Alertas de Tolerancia de 15 minutos en vivo -->
                            @if($toleranciaVencida)
                                <div style="margin-top: 0.3rem; display: inline-block; background: rgba(239, 68, 68, 0.2); color: #fca5a5; border: 1px solid #ef4444; padding: 0.15rem 0.45rem; border-radius: 0.35rem; font-size: 0.72rem; font-weight: 800;">
                                    🚨 Tolerancia Vencida (+{{ $minutosTranscurridos }}m)
                                </div>
                            @elseif($enTolerancia)
                                <div style="margin-top: 0.3rem; display: inline-block; background: rgba(245, 158, 11, 0.2); color: #fde047; border: 1px solid #f59e0b; padding: 0.15rem 0.45rem; border-radius: 0.35rem; font-size: 0.72rem; font-weight: 800;">
                                    ⏳ En Tolerancia (Quedan {{ 15 - $minutosTranscurridos }}m)
                                </div>
                            @endif
                        </td>

                        <!-- Mesa Asignada (Selector Rápido) -->
                        <td style="padding: 0.85rem 1rem;">
                            <form action="{{ route('admin.reservas.assignTable', $res->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('PATCH')
                                <select name="mesa" onchange="this.form.submit()" 
                                        style="background: {{ !empty($res->mesa) ? 'rgba(52, 211, 153, 0.15)' : 'rgba(0,0,0,0.4)' }}; color: {{ !empty($res->mesa) ? '#6ee7b7' : '#cbd5e1' }}; border: 1px solid {{ !empty($res->mesa) ? '#10b981' : 'rgba(255,255,255,0.2)' }}; border-radius: 0.5rem; padding: 0.35rem 0.5rem; font-size: 0.82rem; font-weight: 600; outline: none; cursor: pointer;">
                                    <option value="">🪑 Sin Asignar</option>
                                    <optgroup label="Salón Principal (1-12)">
                                        @for($m = 1; $m <= 12; $m++)
                                            <option value="Mesa {{ $m }}" {{ $res->mesa === "Mesa $m" ? 'selected' : '' }}>Mesa {{ $m }}</option>
                                        @endfor
                                    </optgroup>
                                    <optgroup label="Terraza Gourmet">
                                        <option value="Terraza 1" {{ $res->mesa === 'Terraza 1' ? 'selected' : '' }}>Terraza 1</option>
                                        <option value="Terraza 2" {{ $res->mesa === 'Terraza 2' ? 'selected' : '' }}>Terraza 2</option>
                                        <option value="Terraza 3" {{ $res->mesa === 'Terraza 3' ? 'selected' : '' }}>Terraza 3</option>
                                        <option value="Terraza 4" {{ $res->mesa === 'Terraza 4' ? 'selected' : '' }}>Terraza 4</option>
                                    </optgroup>
                                    <optgroup label="Zona VIP Lounge">
                                        <option value="VIP Lounge 1" {{ $res->mesa === 'VIP Lounge 1' ? 'selected' : '' }}>VIP Lounge 1</option>
                                        <option value="VIP Lounge 2" {{ $res->mesa === 'VIP Lounge 2' ? 'selected' : '' }}>VIP Lounge 2</option>
                                    </optgroup>
                                </select>
                            </form>
                        </td>

                        <!-- Estado Operativo -->
                        <td style="padding: 0.85rem 1rem;">
                            <form action="{{ route('admin.reservas.updateStatus', $res->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('PUT')
                                <select name="estado" onchange="this.form.submit()" 
                                        style="background: {{ $res->estado == 'Confirmada' ? 'rgba(16,185,129,0.2)' : ($res->estado == 'Cancelada' ? 'rgba(239,68,68,0.2)' : ($res->estado == 'Completada' ? 'rgba(59,130,246,0.2)' : 'rgba(234,179,8,0.2)')) }}; color: {{ $res->estado == 'Confirmada' ? '#6ee7b7' : ($res->estado == 'Cancelada' ? '#fca5a5' : ($res->estado == 'Completada' ? '#93c5fd' : '#fde047')) }}; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.5rem; padding: 0.35rem 0.5rem; font-size: 0.82rem; font-weight: 700; outline: none; cursor: pointer;">
                                    <option value="Pendiente" {{ $res->estado === 'Pendiente' ? 'selected' : '' }}>⏳ Pendiente</option>
                                    <option value="Confirmada" {{ $res->estado === 'Confirmada' ? 'selected' : '' }}>✅ Confirmada</option>
                                    <option value="Completada" {{ $res->estado === 'Completada' ? 'selected' : '' }}>🎉 Completada</option>
                                    <option value="Cancelada" {{ $res->estado === 'Cancelada' ? 'selected' : '' }}>❌ Cancelada</option>
                                </select>
                            </form>
                        </td>

                        <!-- Acciones -->
                        <td style="padding: 0.85rem 1rem; text-align: center;">
                            <div style="display: flex; gap: 0.4rem; justify-content: center; align-items: center;">
                                
                                <!-- Botón PDF -->
                                <a href="{{ route('reservas.pdf', $res->id) }}" target="_blank" title="Ver Comprobante PDF" 
                                   style="background: rgba(255,255,255,0.08); color: #cbd5e1; padding: 0.35rem 0.6rem; border-radius: 0.4rem; text-decoration: none; font-size: 0.8rem; border: 1px solid rgba(255,255,255,0.15); transition: background 0.2s;" 
                                   onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                                    📄 PDF
                                </a>

                                <!-- Botón Editar Modal -->
                                <button type="button" onclick="openEditModal({{ json_encode($res) }})" title="Editar Reserva" 
                                        style="background: rgba(56, 189, 248, 0.15); color: #7dd3fc; border: 1px solid rgba(56, 189, 248, 0.3); padding: 0.35rem 0.6rem; border-radius: 0.4rem; font-size: 0.8rem; cursor: pointer;">
                                    ✏️
                                </button>

                                <!-- Botón Eliminar -->
                                <form action="{{ route('admin.reservas.destroy', $res->id) }}" method="POST" 
                                      onsubmit="return confirm('¿Seguro que deseas eliminar la reserva #{{ $res->id }} de {{ addslashes($res->nombre) }}?');" 
                                      style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Eliminar Reserva" 
                                            style="background: rgba(239, 68, 68, 0.15); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3); padding: 0.35rem 0.6rem; border-radius: 0.4rem; font-size: 0.8rem; cursor: pointer;">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 3rem; text-align: center; color: #64748b;">
                            <span style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;">🍽️</span>
                            <h3 style="color: #cbd5e1; font-size: 1.1rem; margin-bottom: 0.2rem;">No se encontraron reservas</h3>
                            <p style="color: #64748b; font-size: 0.85rem; margin: 0;">Prueba cambiando los filtros o buscando por otro cliente.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- 6. PAGINACIÓN -->
    <div style="margin-top: 1.5rem;">
        {{ $reservas->appends(['buscar' => $buscar, 'estado' => $filtroEstado, 'fecha' => $filtroFecha])->links() }}
    </div>

</div>

<!-- 7. MODAL DE EDICIÓN DE RESERVA (Vanilla JS Elegante) -->
<div id="editReservaModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.75); backdrop-filter: blur(5px); z-index: 9999; justify-content: center; align-items: center; padding: 1rem;">
    <div style="background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 1.25rem; width: 100%; max-width: 550px; padding: 1.75rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.8);">
        
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.85rem; margin-bottom: 1.25rem;">
            <h3 style="color: #f43f5e; margin: 0; font-size: 1.25rem; font-weight: 800;" id="modalTitle">✏️ Editar Reserva</h3>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; color: #94a3b8; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>

        <form id="editReservaForm" method="POST">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div style="margin-bottom: 1rem;">
                <label style="display: block; color: #cbd5e1; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.3rem;">Nombre del Cliente *</label>
                <input type="text" name="nombre" id="editNombre" required style="width: 100%; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.15); color: #fff; padding: 0.6rem; border-radius: 0.5rem; font-size: 0.9rem; outline: none;">
            </div>

            <!-- Fila: Teléfono y Comensales -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; color: #cbd5e1; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.3rem;">Teléfono Celular *</label>
                    <input type="text" name="telefono" id="editTelefono" required style="width: 100%; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.15); color: #fff; padding: 0.6rem; border-radius: 0.5rem; font-size: 0.9rem; outline: none;">
                </div>
                <div>
                    <label style="display: block; color: #cbd5e1; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.3rem;">Comensales (Personas) *</label>
                    <input type="number" min="1" max="30" name="personas" id="editPersonas" required style="width: 100%; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.15); color: #fff; padding: 0.6rem; border-radius: 0.5rem; font-size: 0.9rem; outline: none;">
                </div>
            </div>

            <!-- Fila: Fecha y Mesa -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; color: #cbd5e1; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.3rem;">Fecha y Hora *</label>
                    <input type="datetime-local" name="fecha_reserva" id="editFecha" required style="width: 100%; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.15); color: #fff; padding: 0.6rem; border-radius: 0.5rem; font-size: 0.85rem; outline: none;">
                </div>
                <div>
                    <label style="display: block; color: #cbd5e1; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.3rem;">Mesa Asignada</label>
                    <select name="mesa" id="editMesa" style="width: 100%; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.15); color: #fff; padding: 0.6rem; border-radius: 0.5rem; font-size: 0.85rem; outline: none;">
                        <option value="">🪑 Sin Asignar</option>
                        <optgroup label="Salón Principal">
                            @for($m = 1; $m <= 12; $m++)
                                <option value="Mesa {{ $m }}">Mesa {{ $m }}</option>
                            @endfor
                        </optgroup>
                        <optgroup label="Terraza Gourmet">
                            <option value="Terraza 1">Terraza 1</option>
                            <option value="Terraza 2">Terraza 2</option>
                            <option value="Terraza 3">Terraza 3</option>
                            <option value="Terraza 4">Terraza 4</option>
                        </optgroup>
                        <optgroup label="VIP Lounge">
                            <option value="VIP Lounge 1">VIP Lounge 1</option>
                            <option value="VIP Lounge 2">VIP Lounge 2</option>
                        </optgroup>
                    </select>
                </div>
            </div>

            <!-- Fila: Estado y Notas -->
            <div style="margin-bottom: 1rem;">
                <label style="display: block; color: #cbd5e1; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.3rem;">Estado Operativo *</label>
                <select name="estado" id="editEstado" required style="width: 100%; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.15); color: #fff; padding: 0.6rem; border-radius: 0.5rem; font-size: 0.85rem; outline: none;">
                    <option value="Pendiente">⏳ Pendiente</option>
                    <option value="Confirmada">✅ Confirmada</option>
                    <option value="Completada">🎉 Completada</option>
                    <option value="Cancelada">❌ Cancelada</option>
                </select>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #cbd5e1; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.3rem;">Notas y Peticiones Especiales</label>
                <textarea name="notas" id="editNotas" rows="2" placeholder="Ej: Cumpleaños, traer copa de cortesía, silla de bebé..." style="width: 100%; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.15); color: #fff; padding: 0.6rem; border-radius: 0.5rem; font-size: 0.85rem; outline: none;"></textarea>
            </div>

            <!-- Botones Modal -->
            <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                <button type="button" onclick="closeEditModal()" style="background: rgba(255,255,255,0.1); color: #cbd5e1; border: none; padding: 0.6rem 1.2rem; border-radius: 0.6rem; font-weight: 600; cursor: pointer;">
                    Cancelar
                </button>
                <button type="submit" style="background: #e11d48; color: white; border: none; padding: 0.6rem 1.4rem; border-radius: 0.6rem; font-weight: 700; cursor: pointer;">
                    💾 Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(reserva) {
        document.getElementById('editReservaModal').style.display = 'flex';
        document.getElementById('modalTitle').innerText = '✏️ Editar Reserva #' + reserva.id + ' (' + reserva.nombre + ')';
        document.getElementById('editReservaForm').action = '/admin/reservas/' + reserva.id;
        
        document.getElementById('editNombre').value = reserva.nombre || '';
        document.getElementById('editTelefono').value = reserva.telefono || '';
        document.getElementById('editPersonas').value = reserva.personas || 1;
        document.getElementById('editMesa').value = reserva.mesa || '';
        document.getElementById('editEstado').value = reserva.estado || 'Pendiente';
        document.getElementById('editNotas').value = reserva.notas || '';

        if (reserva.fecha_reserva) {
            const d = new Date(reserva.fecha_reserva);
            const pad = (num) => String(num).padStart(2, '0');
            const formatted = d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()) + 'T' + pad(d.getHours()) + ':' + pad(d.getMinutes());
            document.getElementById('editFecha').value = formatted;
        }
    }

    function closeEditModal() {
        document.getElementById('editReservaModal').style.display = 'none';
    }
</script>
@endsection