@extends('layouts.app')

@section('titulo', 'Gestión de Carta y Platos')

@section('contenido')
<div style="width: 100%; padding: 0.5rem 0; text-align: left;">

    <!-- 1. ENCABEZADO Y ACCIONES RÁPIDAS -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 1rem;">
        <div>
            <h1 style="color: #f43f5e; margin: 0; font-size: 1.8rem; font-weight: 800; display: flex; align-items: center; gap: 0.5rem;">
                <span>🍔</span> Gestión de Platos y Carta Gastronómica
            </h1>
            <p style="color: #94a3b8; margin: 0.3rem 0 0 0; font-size: 0.95rem;">
                Administra el menú en tiempo real: precios, disponibilidad, fotografías y porciones en cocina.
            </p>
        </div>
        <div style="display: flex; gap: 0.6rem; align-items: center; flex-wrap: wrap;">
            <a href="{{ route('admin.productos.inventarioPdf') }}" target="_blank"
               title="Generar e imprimir balance de stock y carta gastronómica"
               style="background: rgba(245, 158, 11, 0.15); border: 1px solid #f59e0b; color: #fbbf24; padding: 0.5rem 0.9rem; border-radius: 0.75rem; text-decoration: none; font-weight: 700; font-size: 0.82rem; display: flex; align-items: center; gap: 0.4rem; transition: all 0.2s;">
                <span>🖨️</span> Reporte Carta PDF
            </a>
            <a href="{{ route('admin.dashboard') }}" wire:navigate 
               style="background: rgba(56, 189, 248, 0.12); border: 1px solid #38bdf8; color: #7dd3fc; padding: 0.5rem 0.9rem; border-radius: 0.75rem; text-decoration: none; font-weight: 700; font-size: 0.82rem; display: flex; align-items: center; gap: 0.4rem; transition: all 0.2s;">
                <span>📊</span> Dashboard
            </a>
            <a href="{{ route('admin.productos.create') }}" wire:navigate 
               style="background: linear-gradient(135deg, #e11d48, #be123c); color: white; padding: 0.5rem 1.1rem; border-radius: 0.75rem; text-decoration: none; font-weight: 800; font-size: 0.85rem; display: flex; align-items: center; gap: 0.4rem; box-shadow: 0 10px 20px rgba(225, 29, 72, 0.3); transition: transform 0.2s;"
               onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">
                <span>➕</span> Nuevo Plato Criollo
            </a>
        </div>
    </div>

    <!-- 2. MENSAJES FLASH -->
    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #6ee7b7; padding: 0.85rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem;">
            <span>✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- 3. BARRA DE BÚSQUEDA Y FILTRO -->
    <div style="background: rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.08); border-radius: 1rem; padding: 1rem; margin-bottom: 1.5rem;">
        <form action="{{ route('admin.productos.index') }}" method="GET" style="display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center;">
            <div style="flex: 1; min-width: 240px; position: relative;">
                <input type="text" name="buscar" value="{{ $busqueda ?? '' }}" 
                       placeholder="🔍 Buscar plato criollo o ingredientes..." 
                       style="width: 100%; background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.15); color: #fff; padding: 0.6rem 1rem; border-radius: 0.6rem; font-size: 0.85rem; outline: none;">
            </div>
            <button type="submit" style="background: #e11d48; color: white; border: none; padding: 0.6rem 1.25rem; border-radius: 0.6rem; font-size: 0.85rem; font-weight: 700; cursor: pointer;">
                Filtrar
            </button>
            @if(!empty($busqueda))
                <a href="{{ route('admin.productos.index') }}" style="background: rgba(255,255,255,0.08); color: #cbd5e1; border: 1px solid rgba(255,255,255,0.1); padding: 0.6rem 1rem; border-radius: 0.6rem; font-size: 0.85rem; text-decoration: none;">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    <!-- 4. GRILLA GOURMET DE PLATOS -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
        @forelse($productos as $producto)
            <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 1.25rem; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 15px 30px rgba(0,0,0,0.5); transition: transform 0.2s, border-color 0.2s;"
                 onmouseover="this.style.borderColor='rgba(255,255,255,0.2)'; this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.transform='translateY(0)'">
                
                <div>
                    <!-- Fotografía con Badge de Stock -->
                    <div style="position: relative; height: 170px; width: 100%; background: #020617; overflow: hidden;">
                        <img src="{{ asset('images/platos/' . $producto->imagen) }}" 
                             alt="{{ $producto->nombre }}" 
                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s;"
                             onerror="this.src='{{ asset('images/platos/lomo-saltado.jpg') }}'">

                        <!-- Badge de Disponibilidad -->
                        <div style="position: absolute; top: 0.6rem; right: 0.6rem;">
                            @if($producto->stock > 0)
                                <span style="background: rgba(16, 185, 129, 0.85); backdrop-filter: blur(4px); color: white; padding: 0.2rem 0.6rem; border-radius: 9999px; font-size: 0.72rem; font-weight: 800; border: 1px solid rgba(255,255,255,0.2);">
                                    Stock: {{ $producto->stock }}
                                </span>
                            @else
                                <span style="background: rgba(239, 68, 68, 0.9); backdrop-filter: blur(4px); color: white; padding: 0.2rem 0.6rem; border-radius: 9999px; font-size: 0.72rem; font-weight: 800; border: 1px solid rgba(255,255,255,0.2);">
                                    Agotado
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Contenido Informativo -->
                    <div style="padding: 1rem 1.1rem 0.5rem 1.1rem;">
                        <h3 style="color: #ffffff; font-size: 1.1rem; font-weight: 800; margin: 0; line-height: 1.3;">
                            {{ $producto->nombre }}
                        </h3>
                        <p style="color: #94a3b8; font-size: 0.8rem; margin: 0.4rem 0 0.8rem 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $producto->descripcion }}
                        </p>

                        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 0.5rem; border-top: 1px solid rgba(255,255,255,0.06);">
                            <div>
                                <span style="color: #64748b; font-size: 0.7rem; text-transform: uppercase; font-weight: 700; display: block;">Precio Carta</span>
                                <span style="color: #f59e0b; font-size: 1.3rem; font-weight: 900;">S/ {{ number_format($producto->precio, 2) }}</span>
                            </div>

                            <!-- Switch de Disponibilidad Rápida -->
                            <form action="{{ route('admin.productos.toggleStock', $producto->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        title="{{ $producto->stock > 0 ? 'Clic para marcar como Agotado' : 'Clic para reponer 15 porciones' }}"
                                        style="background: {{ $producto->stock > 0 ? 'rgba(245, 158, 11, 0.15)' : 'rgba(16, 185, 129, 0.15)' }}; color: {{ $producto->stock > 0 ? '#fbbf24' : '#6ee7b7' }}; border: 1px solid {{ $producto->stock > 0 ? 'rgba(245, 158, 11, 0.3)' : 'rgba(16, 185, 129, 0.3)' }}; padding: 0.35rem 0.65rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: all 0.2s;">
                                    {{ $producto->stock > 0 ? '⚡ Agotar' : '⚡ Activar' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción (Editar / Eliminar) -->
                <div style="padding: 0.85rem 1.1rem; background: rgba(0,0,0,0.3); border-top: 1px solid rgba(255,255,255,0.06); display: flex; gap: 0.5rem; margin-top: 0.5rem;">
                    <a href="{{ route('admin.productos.edit', $producto->id) }}" wire:navigate
                       style="flex: 1; background: rgba(255,255,255,0.08); color: #f1f5f9; padding: 0.45rem; border-radius: 0.5rem; text-decoration: none; font-size: 0.8rem; font-weight: 700; text-align: center; border: 1px solid rgba(255,255,255,0.12); display: flex; align-items: center; justify-content: center; gap: 0.3rem;">
                        <span>✏️</span> Editar
                    </a>
                    <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST"
                          onsubmit="return confirm('¿Seguro que deseas retirar {{ addslashes($producto->nombre) }} de la carta?');"
                          style="flex: 1; margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                style="width: 100%; background: rgba(239, 68, 68, 0.15); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3); padding: 0.45rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.3rem;">
                            <span>🗑️</span> Borrar
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div style="grid-column: 1 / -1; padding: 3.5rem 1rem; text-align: center; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.08); border-radius: 1.25rem;">
                <span style="font-size: 3rem; display: block; margin-bottom: 0.5rem;">🍽️</span>
                <h3 style="color: #ffffff; font-size: 1.2rem; font-weight: 800; margin: 0;">No se encontraron platos</h3>
                <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 0.3rem;">Prueba buscando otro nombre o agrega un nuevo plato criollo a la carta.</p>
            </div>
        @endforelse
    </div>

    <!-- 5. PAGINACIÓN -->
    <div style="margin-top: 1.5rem;">
        {{ $productos->appends(['buscar' => $busqueda])->links() }}
    </div>

</div>
@endsection
