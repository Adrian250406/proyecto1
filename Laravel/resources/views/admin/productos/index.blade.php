@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Encabezado y Botón Crear -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between pb-6 border-b border-neutral-800 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-white flex items-center gap-3">
                    <span>🍔</span> Gestión de Platos y Carta Gastronómica
                </h1>
                <p class="text-neutral-400 text-sm mt-1">
                    Administra el menú en tiempo real: precios, disponibilidad, fotografías y porciones en cocina.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.productos.inventarioPdf') }}" target="_blank"
                    title="Generar e imprimir balance de stock y carta gastronómica"
                    class="px-4 py-2 bg-neutral-800 hover:bg-neutral-700 text-amber-300 border border-amber-500/30 rounded-xl text-sm font-semibold flex items-center gap-2 transition">
                    <span>🖨️</span> Reporte Carta PDF
                </a>
                <a href="{{ route('admin.dashboard') }}"
                    class="px-4 py-2 bg-neutral-800 hover:bg-neutral-700 text-neutral-300 rounded-xl text-sm font-semibold transition">
                    ← Dashboard
                </a>
                <a href="{{ route('admin.productos.create') }}"
                    class="px-5 py-2.5 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white rounded-xl text-sm font-bold shadow-lg shadow-red-900/30 flex items-center gap-2 transition transform hover:scale-105">
                    <span>➕</span> Nuevo Plato Criollo
                </a>
            </div>
        </div>

        <!-- Alertas Flash -->
        @if(session('success'))
            <div
                class="mt-6 p-4 bg-emerald-950/60 border border-emerald-500/30 rounded-2xl flex items-center gap-3 text-emerald-300 text-sm shadow-lg animate-fade-in">
                <span class="text-xl">✅</span>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Barra de Búsqueda y Filtros -->
        <div class="mt-6 bg-neutral-900/70 border border-neutral-800/80 rounded-2xl p-4 backdrop-blur-md">
            <form action="{{ route('admin.productos.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-neutral-500">🔍</span>
                    <input type="text" name="buscar" value="{{ $busqueda ?? '' }}"
                        placeholder="Buscar por nombre de plato o ingredientes..."
                        class="w-full pl-10 pr-4 py-2.5 bg-neutral-950 border border-neutral-800 rounded-xl text-white text-sm focus:outline-none focus:border-red-500 transition">
                </div>
                <button type="submit"
                    class="px-6 py-2.5 bg-neutral-800 hover:bg-neutral-700 text-white text-sm font-semibold rounded-xl transition">
                    Filtrar
                </button>
                @if(!empty($busqueda))
                    <a href="{{ route('admin.productos.index') }}"
                        class="px-4 py-2.5 bg-neutral-950 border border-neutral-800 hover:bg-neutral-800 text-neutral-400 text-sm rounded-xl flex items-center justify-center transition">
                        Limpiar
                    </a>
                @endif
            </form>
        </div>

        <!-- Grilla de Platos -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($productos as $producto)
                <div
                    class="bg-neutral-900/80 border border-neutral-800 rounded-2xl overflow-hidden shadow-xl flex flex-col justify-between hover:border-neutral-700 transition">
                    <div>
                        <!-- Fotografía con Badge de Stock -->
                        <div class="relative h-44 w-full bg-neutral-950 overflow-hidden">
                            <img src="{{ asset('images/platos/' . $producto->imagen) }}" alt="{{ $producto->nombre }}"
                                class="w-full h-full object-cover transform hover:scale-110 transition duration-500"
                                onerror="this.src='{{ asset('images/platos/lomo-saltado.jpg') }}'">

                            <!-- Badge de Disponibilidad -->
                            <div class="absolute top-3 right-3">
                                @if($producto->stock > 0)
                                    <span
                                        class="px-3 py-1 bg-emerald-950/80 border border-emerald-500/40 text-emerald-300 text-xs font-bold rounded-full backdrop-blur-md shadow">
                                        Stock: {{ $producto->stock }}
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-red-950/90 border border-red-500/50 text-red-300 text-xs font-bold rounded-full backdrop-blur-md shadow">
                                        Agotado
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Contenido Informativo -->
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-white leading-snug">{{ $producto->nombre }}</h3>
                            <p class="text-neutral-400 text-xs mt-1 line-clamp-2">{{ $producto->descripcion }}</p>

                            <div class="mt-4 flex items-center justify-between">
                                <div>
                                    <span class="text-xs text-neutral-500 block">Precio Carta</span>
                                    <span class="text-xl font-extrabold text-amber-400">S/
                                        {{ number_format($producto->precio, 2) }}</span>
                                </div>

                                <!-- Switch de Disponibilidad Rápida -->
                                <form action="{{ route('admin.productos.toggleStock', $producto->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        title="{{ $producto->stock > 0 ? 'Hacer clic para marcar como Agotado' : 'Hacer clic para habilitar stock' }}"
                                        class="px-3 py-1.5 rounded-lg text-xs font-semibold border transition {{ $producto->stock > 0 ? 'bg-amber-500/10 border-amber-500/30 text-amber-300 hover:bg-amber-500/20' : 'bg-emerald-500/10 border-emerald-500/30 text-emerald-300 hover:bg-emerald-500/20' }}">
                                        {{ $producto->stock > 0 ? '⚡ Agotar' : '⚡ Activar' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción (Editar / Eliminar) -->
                    <div class="p-4 bg-neutral-950/60 border-t border-neutral-800/80 flex items-center justify-between gap-2">
                        <a href="{{ route('admin.productos.edit', $producto->id) }}"
                            class="flex-1 py-2 bg-neutral-800 hover:bg-neutral-700 text-neutral-200 text-xs font-bold rounded-xl text-center transition flex items-center justify-center gap-1">
                            <span>✏️</span> Editar
                        </a>
                        <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST"
                            onsubmit="return confirm('¿Seguro que deseas eliminar {{ addslashes($producto->nombre) }} de la carta?');"
                            class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full py-2 bg-red-950/50 hover:bg-red-900/60 text-red-300 border border-red-800/40 text-xs font-bold rounded-xl transition flex items-center justify-center gap-1">
                                <span>🗑️</span> Borrar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-neutral-900/40 border border-neutral-800 rounded-3xl">
                    <span class="text-5xl block mb-3">🍽️</span>
                    <h3 class="text-lg font-bold text-white">No se encontraron platos</h3>
                    <p class="text-neutral-500 text-sm mt-1">Intenta con otro término de búsqueda o agrega un nuevo plato
                        criollo.</p>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        <div class="mt-8">
            {{ $productos->appends(['buscar' => $busqueda])->links() }}
        </div>
    </div>
@endsection
