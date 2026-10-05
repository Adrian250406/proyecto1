@extends('layouts.app')

@section('titulo', 'Nuevo Plato Criollo')

@section('contenido')
<div style="width: 100%; max-width: 750px; margin: 0 auto; padding: 0.5rem 0;">
    
    <!-- Encabezado -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 1rem;">
        <div>
            <h1 style="color: #f43f5e; margin: 0; font-size: 1.8rem; font-weight: 800; display: flex; align-items: center; gap: 0.5rem;">
                <span>➕</span> Nuevo Plato Criollo
            </h1>
            <p style="color: #94a3b8; margin: 0.3rem 0 0 0; font-size: 0.95rem;">
                Registra una nueva delicia gastronómica para la carta de "El Buen Sabor".
            </p>
        </div>
        <a href="{{ route('admin.productos.index') }}" wire:navigate
           style="background: rgba(255,255,255,0.08); color: #cbd5e1; border: 1px solid rgba(255,255,255,0.12); padding: 0.5rem 1rem; border-radius: 0.75rem; text-decoration: none; font-weight: 700; font-size: 0.85rem; transition: all 0.2s;">
            ← Volver a Platos
        </a>
    </div>

    <!-- Formulario -->
    <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.08); border-radius: 1.25rem; padding: 1.5rem; box-shadow: 0 20px 40px rgba(0,0,0,0.6);">
        <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nombre del Plato -->
            <div style="margin-bottom: 1.25rem;">
                <label for="nombre" style="display: block; color: #cbd5e1; font-size: 0.85rem; font-weight: 700; margin-bottom: 0.4rem;">
                    Nombre del Plato <span style="color: #f43f5e;">*</span>
                </label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                       placeholder="Ej: Lomo Saltado Especial al Pisco"
                       style="width: 100%; background: rgba(0,0,0,0.4); border: 1px solid {{ $errors->has('nombre') ? '#ef4444' : 'rgba(255,255,255,0.15)' }}; color: #fff; padding: 0.7rem 1rem; border-radius: 0.6rem; font-size: 0.9rem; outline: none;">
                @error('nombre')
                    <p style="color: #f87171; font-size: 0.78rem; margin-top: 0.3rem;">⚠️ {{ $message }}</p>
                @enderror
            </div>

            <!-- Fila: Precio y Stock -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.25rem;">
                <!-- Precio -->
                <div>
                    <label for="precio" style="display: block; color: #cbd5e1; font-size: 0.85rem; font-weight: 700; margin-bottom: 0.4rem;">
                        Precio de Carta (S/ PEN) <span style="color: #f43f5e;">*</span>
                    </label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #f59e0b; font-weight: 800;">S/</span>
                        <input type="number" step="0.50" min="0.50" name="precio" id="precio" value="{{ old('precio') }}" required
                               placeholder="45.00"
                               style="width: 100%; background: rgba(0,0,0,0.4); border: 1px solid {{ $errors->has('precio') ? '#ef4444' : 'rgba(255,255,255,0.15)' }}; color: #fff; padding: 0.7rem 1rem 0.7rem 2.2rem; border-radius: 0.6rem; font-size: 0.9rem; outline: none;">
                    </div>
                    @error('precio')
                        <p style="color: #f87171; font-size: 0.78rem; margin-top: 0.3rem;">⚠️ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock Inicial -->
                <div>
                    <label for="stock" style="display: block; color: #cbd5e1; font-size: 0.85rem; font-weight: 700; margin-bottom: 0.4rem;">
                        Porciones en Cocina (Stock) <span style="color: #f43f5e;">*</span>
                    </label>
                    <input type="number" min="0" name="stock" id="stock" value="{{ old('stock', 20) }}" required
                           placeholder="20"
                           style="width: 100%; background: rgba(0,0,0,0.4); border: 1px solid {{ $errors->has('stock') ? '#ef4444' : 'rgba(255,255,255,0.15)' }}; color: #fff; padding: 0.7rem 1rem; border-radius: 0.6rem; font-size: 0.9rem; outline: none;">
                    @error('stock')
                        <p style="color: #f87171; font-size: 0.78rem; margin-top: 0.3rem;">⚠️ {{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Descripción Gastronómica -->
            <div style="margin-bottom: 1.25rem;">
                <label for="descripcion" style="display: block; color: #cbd5e1; font-size: 0.85rem; font-weight: 700; margin-bottom: 0.4rem;">
                    Descripción Gastronómica e Ingredientes <span style="color: #f43f5e;">*</span>
                </label>
                <textarea name="descripcion" id="descripcion" rows="3" required
                          placeholder="Describe el corte de carne, guarniciones, tipo de cocción y notas de sabor..."
                          style="width: 100%; background: rgba(0,0,0,0.4); border: 1px solid {{ $errors->has('descripcion') ? '#ef4444' : 'rgba(255,255,255,0.15)' }}; color: #fff; padding: 0.7rem 1rem; border-radius: 0.6rem; font-size: 0.9rem; outline: none;">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p style="color: #f87171; font-size: 0.78rem; margin-top: 0.3rem;">⚠️ {{ $message }}</p>
                @enderror
            </div>

            <!-- Fotografía del Plato -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #cbd5e1; font-size: 0.85rem; font-weight: 700; margin-bottom: 0.4rem;">
                    Fotografía del Plato (JPG, PNG, WEBP - Máx 3MB)
                </label>
                <div style="background: rgba(0,0,0,0.3); border: 2px dashed rgba(255,255,255,0.15); border-radius: 1rem; padding: 1.5rem; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📸</div>
                    <label for="imagen" style="display: inline-block; background: rgba(245, 158, 11, 0.15); border: 1px solid #f59e0b; color: #fbbf24; padding: 0.5rem 1.25rem; border-radius: 0.6rem; font-size: 0.85rem; font-weight: 700; cursor: pointer; transition: all 0.2s;">
                        Seleccionar Archivo de Imagen
                    </label>
                    <input id="imagen" name="imagen" type="file" accept="image/*" style="display: none;" onchange="previewImage(event)">
                    <p style="color: #64748b; font-size: 0.75rem; margin-top: 0.5rem;">Resolución recomendada: 800x600 px en alta definición</p>
                </div>
                
                <!-- Vista previa -->
                <div id="imagePreviewContainer" style="display: none; margin-top: 1rem; text-align: center;">
                    <p style="color: #38bdf8; font-size: 0.8rem; font-weight: 700; margin-bottom: 0.4rem;">Vista Previa de la Fotografía:</p>
                    <img id="imagePreview" src="#" alt="Previsualización" style="max-height: 180px; width: auto; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 10px 25px rgba(0,0,0,0.5); object-fit: cover;">
                </div>
                @error('imagen')
                    <p style="color: #f87171; font-size: 0.78rem; margin-top: 0.3rem;">⚠️ {{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div style="display: flex; justify-content: flex-end; gap: 0.75rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.08);">
                <a href="{{ route('admin.productos.index') }}" wire:navigate
                   style="background: rgba(255,255,255,0.08); color: #cbd5e1; border: 1px solid rgba(255,255,255,0.12); padding: 0.6rem 1.25rem; border-radius: 0.6rem; text-decoration: none; font-weight: 600; font-size: 0.85rem;">
                    Cancelar
                </a>
                <button type="submit" 
                        style="background: linear-gradient(135deg, #e11d48, #be123c); color: white; border: none; padding: 0.6rem 1.5rem; border-radius: 0.6rem; font-weight: 800; font-size: 0.85rem; cursor: pointer; box-shadow: 0 10px 20px rgba(225, 29, 72, 0.4);">
                    💾 Guardar Plato en Carta
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
                container.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
