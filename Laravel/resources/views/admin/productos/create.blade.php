@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Encabezado -->
    <div class="flex items-center justify-between pb-6 border-b border-neutral-800">
        <div>
            <h1 class="text-3xl font-extrabold text-white flex items-center gap-3">
                <span>➕</span> Nuevo Plato Criollo
            </h1>
            <p class="text-neutral-400 text-sm mt-1">
                Registra una nueva delicia gastronómica para la carta de "El Buen Sabor".
            </p>
        </div>
        <a href="{{ route('admin.productos.index') }}" 
           class="px-4 py-2 bg-neutral-800 hover:bg-neutral-700 text-neutral-300 rounded-xl text-sm font-semibold transition">
            ← Volver a Platos
        </a>
    </div>

    <!-- Formulario -->
    <div class="mt-8 bg-neutral-900/90 border border-neutral-800 rounded-3xl p-6 sm:p-8 backdrop-blur-md shadow-2xl">
        <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Nombre del Plato -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-neutral-300 mb-2">
                    Nombre del Plato <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                       placeholder="Ej: Lomo Saltado Especial al Pisco"
                       class="w-full px-4 py-3 bg-neutral-950 border border-neutral-800 rounded-xl text-white placeholder-neutral-500 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition @error('nombre') border-red-500 @enderror">
                @error('nombre')
                    <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><span>⚠️</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Fila: Precio y Stock Inicial -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Precio en Soles -->
                <div>
                    <label for="precio" class="block text-sm font-medium text-neutral-300 mb-2">
                        Precio de Carta (S/ PEN) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-neutral-500 font-bold">S/</span>
                        <input type="number" step="0.50" min="0.50" name="precio" id="precio" value="{{ old('precio') }}" required
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
                    <input type="number" min="0" name="stock" id="stock" value="{{ old('stock', 20) }}" required
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
                          class="w-full px-4 py-3 bg-neutral-950 border border-neutral-800 rounded-xl text-white placeholder-neutral-500 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition @error('descripcion') border-red-500 @enderror">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><span>⚠️</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Fotografía del Plato -->
            <div>
                <label class="block text-sm font-medium text-neutral-300 mb-2">
                    Fotografía del Plato (JPG, PNG, WEBP - Máx 3MB)
                </label>
                <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-800 border-dashed rounded-2xl bg-neutral-950/50 hover:border-neutral-700 transition">
                    <div class="space-y-2 text-center">
                        <div class="text-4xl">📸</div>
                        <div class="flex text-sm text-neutral-400 justify-center">
                            <label for="imagen" class="relative cursor-pointer bg-neutral-800 rounded-lg px-3 py-1.5 font-medium text-amber-400 hover:text-amber-300 transition">
                                <span>Seleccionar archivo</span>
                                <input id="imagen" name="imagen" type="file" accept="image/*" class="sr-only" onchange="previewImage(event)">
                            </label>
                        </div>
                        <p class="text-xs text-neutral-500">Formatos recomendados: 800x600 px en alta definición</p>
                    </div>
                </div>
                
                <!-- Vista previa de la imagen -->
                <div id="imagePreviewContainer" class="hidden mt-4 text-center">
                    <p class="text-xs text-neutral-400 mb-2 font-medium">Vista Previa:</p>
                    <img id="imagePreview" src="#" alt="Previsualización" class="mx-auto h-44 w-72 object-cover rounded-2xl border border-neutral-700 shadow-lg">
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
                        class="px-8 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white rounded-xl font-bold text-sm shadow-xl shadow-red-900/40 transform hover:scale-105 transition flex items-center gap-2">
                    <span>💾</span> Guardar Plato en Carta
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        const container = document.getElementById('imagePreviewContainer');
        
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
