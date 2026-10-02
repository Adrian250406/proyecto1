<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use App\Services\TipoCambioService;

class BuscarPlatos extends Component
{
    // Variable reactiva que almacena el texto del buscador
    public $busqueda = '';

    public function render(TipoCambioService $tipoCambioService)
    {
        // 1. Consulta reactiva a la base de datos MySQL
        $productos = Producto::where('nombre', 'like', '%' . $this->busqueda . '%')
            ->orWhere('descripcion', 'like', '%' . $this->busqueda . '%')
            ->get();

        // 2. Consumo del Microservicio de Tipo de Cambio
        $tipoCambio = $tipoCambioService->obtenerTipoCambioDolar();

        return view('livewire.buscar-platos', [
            'productos'  => $productos,
            'tipoCambio' => $tipoCambio
        ]);
    }
}
