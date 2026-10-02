<div>
    {{-- Campo de búsqueda reactivo con Livewire (wire:model.live) --}}
    <div style="margin-bottom: 1rem;">
        <input type="text" 
               wire:model.live="busqueda" 
               placeholder="🔍 Buscar plato (ej: lomo, ceviche, causa, chicha)..." 
               style="width: 100%; padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.3); color: white; font-size: 1rem; outline: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
    </div>

    {{-- Indicador de Microservicio Activo --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.8rem; color: #94a3b8;">
        <span>⚡ <em>Búsqueda en tiempo real activa (Livewire)</em></span>
        <span style="background: rgba(59, 130, 246, 0.15); color: #93c5fd; padding: 0.2rem 0.6rem; border-radius: 9999px;">
            💵 Microservicio Tipo Cambio: 1 USD = S/ {{ number_format($tipoCambio, 2) }}
        </span>
    </div>

    {{-- Indicador de carga sutil cuando Livewire consulta la BD --}}
    <div wire:loading style="color: #f43f5e; font-size: 0.9rem; margin-bottom: 1rem; text-align: left;">
        ⏳ Filtrando carta al instante...
    </div>

    {{-- Listado de platos filtrados en tiempo real --}}
    <div style="display: flex; flex-direction: column; gap: 1.2rem;">
        @forelse($productos as $p)
            <div style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 1rem; padding: 1.5rem; text-align: left; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="color: #f8fafc; font-size: 1.2rem; margin-bottom: 0.3rem;">{{ $p->nombre }}</h3>
                    <p style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 0.5rem;">{{ $p->descripcion }}</p>
                    <span style="font-size: 0.8rem; background: rgba(16, 185, 129, 0.2); color: #6ee7b7; padding: 0.2rem 0.6rem; border-radius: 9999px;">
                        Disponibles: {{ $p->stock }} porciones
                    </span>
                </div>
                <div style="text-align: right; min-width: 120px;">
                    <div style="font-size: 1.4rem; font-weight: bold; color: #f43f5e;">
                        S/ {{ number_format($p->precio, 2) }}
                    </div>
                    <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.2rem;">
                        ≈ ${{ number_format($p->precio / $tipoCambio, 2) }} USD
                    </div>
                </div>
            </div>
        @empty
            <div style="padding: 2rem; text-align: center; color: #64748b; background: rgba(255,255,255,0.02); border-radius: 0.75rem;">
                No encontramos ningún plato que coincida con "<strong>{{ $busqueda }}</strong>".
            </div>
        @endforelse
    </div>
</div>
