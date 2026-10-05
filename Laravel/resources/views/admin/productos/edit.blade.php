@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Encabezado -->
    <div class="flex items-center justify-between pb-6 border-b border-neutral-800">
        <div>
            <h1 class="text-3xl font-extrabold text-white flex items-center gap-3">
                <span>✏️</span> Editar Plato: {{ $producto->nombre }}
            </h1>
            <p class="text-neutral-400 text-sm mt-1">
                Actualiza los precios, stock en cocina, recetas o fotografía del plato.
            </p>
        </div>
        <a href="{{ route('admin.productos.index') }}" 
           class="px-4 py-2 bg-neutral-800 hover:bg-neutral-700 text-neutral-300 rounded-xl text-sm font-semibold transition">
            ← Volver a Platos
        </a>
    </div>

    <!-- Formulario de Edición -->
    <div class="mt-8 bg-neutral-900/90 border border-neutral-800 rounded-3xl p-6 sm:p-8 backdrop-blur-md shadow-2xl">
        <form action="{{ route('admin.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nombre del Plato -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-neutral-300 mb-2">
                    Nombre del Plato <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre) }}" required
                       placeholder="Ej: Lomo Saltado Especial al Pisco"
                       class="w-full px-4 py-3 bg-neutral-950 border border-neutral-800 rounded-xl text-white placeholder-neutral-500 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition @error('nombre') border-red-500 @enderror">
                @error('nombre')
                    <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><span>⚠️</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Fila: Precio y Stock -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Precio en Soles -->
                <div>
                    <label for="precio" class="block text-sm font-medium text-neutral-300 mb-2">
                        Precio de Carta (S/ PEN) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-neutral-500 font-bold">S/</span>
                        <input type="number" step="0.50" min="0.50" name="precio" id="precio" value="{{ old('precio', $producto->precio) }}" required
                               placeholder="45.00"
                               class="w-full pl-10 pr-4 py-3 bg-neutral-950 border border-neutral-800 rounded-xl text-white placeholder-neutral-500 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition @error('precio') border-red-500 @enderror">
                    </div>
                    @error('precio')
                        <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><span>⚠️</span> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock / Porciones en Cocina -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-neutral-300 mb-2">
                        Porciones en Cocina (Stock) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" min="0" name="stock" id="stock" value="{{ old('stock', $producto->stock) }}" required
                           placeholder="20"
                           class="w-full px-4 py-3 bg-neutral-950 border border-neutral-800 rounded-xl text-white placeholder-neutral-500 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition @error('stock') border-red-500 @enderror">
                    @error('stock')
                        <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><span>⚠️</span> {{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Descripción Gastronómica -->
            <div>
                <label for="descripcion" class="block text-sm font-medium text-neutral-300 mb-2">
                    Descripción Gastronómica e Ingredientes <span class="text-red-500">*</span>
                </label>
                <textarea name="descripcion" id="descripcion" rows="4" required
                          placeholder="Describe el corte de carne, guarniciones, tipo de cocción y notas de sabor..."
                          class="w-full px-4 py-3 bg-neutral-950 border border-neutral-800 rounded-xl text-white placeholder-neutral-500 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $producto->descripcion) }}</textarea>
                @error('descripcion')
                    <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><span>⚠️</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Fotografía Actual y Reemplazo -->
            <div>
                <label class="block text-sm font-medium text-neutral-300 mb-2">
                    Fotografía del Plato (JPG, PNG, WEBP - Máx 3MB)
                </label>
                
                <div class="flex flex-col sm:flex-row items-center gap-6 p-4 bg-neutral-950 rounded-2xl border border-neutral-800">
                    <div class="text-center sm:text-left">
                        <span class="text-xs text-neutral-400 block mb-2 font-medium">Foto Actual:</span>
                        <img src="{{ asset('images/platos/' . $producto->imagen) }}" 
                             alt="{{ $producto->nombre }}"
                             class="h-28 w-44 object-cover rounded-xl border border-neutral-700 shadow"
                             onerror="this.src='{{ asset('images/platos/lomo-saltado.jpg') }}'">
                    </div>

                    <div class="flex-1 w-full text-center sm:text-left">
                        <label for="imagen" class="cursor-pointer inline-block bg-neutral-800 hover:bg-neutral-700 text-amber-400 hover:text-amber-300 px-4 py-2.5 rounded-xl text-sm font-semibold transition">
                            📷 Cambiar Fotografía
                        </label>
                        <input id="imagen" name="imagen" type="file" accept="image/*" class="sr-only" onchange="previewEditImage(event)">
                        <p class="text-xs text-neutral-500 mt-2">Deja este campo vacío si deseas conservar la fotografía actual.</p>
                    </div>
                </div>

                <!-- Vista Previa si sube nueva foto -->
                <div id="newImagePreviewContainer" class="hidden mt-4 text-center">
                    <p class="text-xs text-amber-400 mb-2 font-medium">Nueva Foto Seleccionada:</p>
                    <img id="newImagePreview" src="#" alt="Nueva Previsualización" class="mx-auto h-40 w-64 object-cover rounded-2xl border-2 border-amber-500/50 shadow-xl">
                </div>
                @error('imagen')
                    <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><span>⚠️</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Botones de Acción -->
            <div class="pt-6 border-t border-neutral-800 flex items-center justify-end gap-4">
                <a href="{{ route('admin.productos.index') }}" 
                   class="px-5 py-3 bg-neutral-800 hover:bg-neutral-700 text-neutral-300 rounded-xl font-semibold text-sm transition">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-amber-600 to-yellow-600 hover:from-amber-500 hover:to-yellow-500 text-black font-extrabold rounded-xl text-sm shadow-xl shadow-amber-900/30 transform hover:scale-105 transition flex items-center gap-2">
                    <span>💾</span> Actualizar Plato
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewEditImage(event) {
        const input = event.target;
        const preview = document.getElementById('newImagePreview');
        const container = document.getElementById('newImagePreviewContainer');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
