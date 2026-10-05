<div>
    {{-- 🔍 CAMPO DE BÚSQUEDA REACTIVO EN TIEMPO REAL --}}
    <div style="margin-bottom: 1.2rem;">
        <input type="text" wire:model.live="busqueda"
            placeholder="🔍 Buscar plato (ej: ceviche, lomo, anticuchos, causa)..."
            style="width: 100%; padding: 0.9rem 1.2rem; border-radius: 0.85rem; border: 1px solid rgba(255,255,255,0.15); background: rgba(0,0,0,0.35); color: white; font-size: 1rem; outline: none; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
    </div>

    {{-- 💵 INDICADOR DE MICROSERVICIO --}}
    <div
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.82rem; color: #94a3b8; flex-wrap: wrap; gap: 0.5rem;">
        <span>⚡ <em>Filtrado reactivo instantáneo (Livewire v4)</em></span>
        <span
            style="background: rgba(59, 130, 246, 0.15); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.3); padding: 0.25rem 0.75rem; border-radius: 9999px; font-weight: 600;">
            💵 Microservicio Tipo de Cambio: 1 USD = S/ {{ number_format($tipoCambio, 2) }}
        </span>
    </div>

    {{-- ⏳ INDICADOR DE CARGA SUAVE --}}
    <div wire:loading
        style="color: #f43f5e; font-size: 0.9rem; margin-bottom: 1rem; text-align: left; font-weight: 600;">
        ⏳ Filtrando carta en tiempo real...
    </div>

    {{-- 🍽️ CUADRÍCULA DE TARJETAS DE PLATOS CON FOTOS --}}
    <div
        style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem; text-align: left;">
        @forelse($productos as $p)
            <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.25s ease, box-shadow 0.25s ease; box-shadow: 0 10px 20px rgba(0,0,0,0.3);"
                onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.5)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.3)';">

                {{-- FOTO DEL PLATO --}}
                <div style="height: 180px; width: 100%; overflow: hidden; background: #0b0f19;">
                    @if($p->imagen && file_exists(public_path('images/platos/' . $p->imagen)))
                        <img src="{{ asset('images/platos/' . $p->imagen) }}" alt="{{ $p->nombre }}"
                            style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
                            onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    @else
                        <div
                            style="display: flex; align-items: center; justify-content: center; height: 100%; font-size: 3rem; background: rgba(255,255,255,0.02);">
                            🍽️
                        </div>
                    @endif
                </div>

                {{-- INFORMACIÓN Y PRECIOS --}}
                <div
                    style="padding: 1.25rem; display: flex; flex-direction: column; flex-grow: 1; justify-content: space-between;">
                    <div>
                        <div
                            style="display: flex; justify-content: space-between; align-items: flex-start; gap: 0.5rem; margin-bottom: 0.4rem;">
                            <h3 style="color: #f8fafc; font-size: 1.1rem; font-weight: 700; line-height: 1.3;">
                                {{ $p->nombre }}</h3>
                        </div>
                        <p style="color: #94a3b8; font-size: 0.85rem; line-height: 1.5; margin-bottom: 0.8rem;">
                            {{ $p->descripcion }}</p>
                    </div>

                    <div>
                        <div
                            style="display: flex; justify-content: space-between; align-items: flex-end; padding-top: 0.8rem; border-top: 1px solid rgba(255,255,255,0.06); margin-bottom: 0.8rem;">
                            <div>
                                <span
                                    style="font-size: 0.75rem; background: rgba(16, 185, 129, 0.15); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.3); padding: 0.2rem 0.55rem; border-radius: 9999px; font-weight: 600;">
                                    Stock: {{ $p->stock }}
                                </span>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 1.3rem; font-weight: 800; color: #f43f5e;">
                                    S/ {{ number_format($p->precio, 2) }}
                                </div>
                                <div style="font-size: 0.78rem; color: #94a3b8; font-weight: 500;">
                                    ≈ ${{ number_format($p->precio / $tipoCambio, 2) }} USD
                                </div>
                            </div>
                        </div>

                        <a href="{{ url('/reservas') }}" wire:navigate
                            style="display: block; width: 100%; text-align: center; background: rgba(244, 63, 94, 0.15); border: 1px solid rgba(244, 63, 94, 0.4); color: #fca5a5; padding: 0.6rem; border-radius: 0.65rem; font-weight: 700; font-size: 0.88rem; text-decoration: none; transition: background 0.2s;"
                            onmouseover="this.style.background='#f43f5e'; this.style.color='#fff';"
                            onmouseout="this.style.background='rgba(244, 63, 94, 0.15)'; this.style.color='#fca5a5';">
                            📅 Reservar Mesa para Probarlo ➔
                        </a>
                    </div>
                </div>

            </div>
        @empty
            <div
                style="grid-column: 1 / -1; padding: 3rem 1.5rem; text-align: center; color: #64748b; background: rgba(255,255,255,0.02); border-radius: 1rem;">
                <span style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;">🔍</span>
                No encontramos ningún plato que coincida con "<strong>{{ $busqueda }}</strong>".
            </div>
        @endforelse
    </div>
</div>