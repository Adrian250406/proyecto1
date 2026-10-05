<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\reserva;
use App\Models\Producto;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Muestra el Dashboard Ejecutivo de Analítica y Estadísticas del Restaurante.
     */
    public function index()
    {
        // 1. Estadísticas de Reservas
        $totalReservas = reserva::count();
        $totalPersonas = reserva::sum('personas');
        $pendientes    = reserva::where('estado', 'Pendiente')->count();
        $confirmadas   = reserva::where('estado', 'Confirmada')->count();
        $completadas   = reserva::where('estado', 'Completada')->count();
        $canceladas    = reserva::where('estado', 'Cancelada')->count();

        // 2. Estadísticas de la Carta Gastronómica
        $totalPlatos   = Producto::count();
        $stockTotal    = Producto::sum('stock');

        // 3. Últimas 5 reservas recientes para vista ejecutiva
        $reservasRecientes = reserva::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalReservas',
            'totalPersonas',
            'pendientes',
            'confirmadas',
            'completadas',
            'canceladas',
            'totalPlatos',
            'stockTotal',
            'reservasRecientes'
        ));
    }
}
