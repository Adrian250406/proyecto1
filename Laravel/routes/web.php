<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\ProductoController as AdminProductoController;
use App\Http\Controllers\Admin\ReporteController;

/*
|--------------------------------------------------------------------------
| 1. RUTAS PÚBLICAS (Para todos los clientes)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/menu', function () {
    return view('menu');
})->name('menu');

Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

Route::get('/reservas', function () {
    return view('reservas');
})->name('reservas.create');

Route::get('/reservas/{id}/pdf', [ReservaController::class, 'descargarPdf'])->name('reservas.pdf');

Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');

/*
|--------------------------------------------------------------------------
| 2. RUTAS DE AUTENTICACIÓN (Login / Logout)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 3. RUTAS PROTEGIDAS (Solo Administrador con Sesión Iniciada)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // ⚙️ Gestión de Salón y Reservas (Avance 4)
    Route::get('/reservas', [ReservaController::class, 'index'])->name('admin.reservas.index');
    Route::put('/reservas/{id}', [ReservaController::class, 'update'])->name('admin.reservas.update');
    Route::put('/reservas/{id}/status', [ReservaController::class, 'updateStatus'])->name('admin.reservas.updateStatus');
    Route::patch('/reservas/{id}/mesa', [ReservaController::class, 'assignTable'])->name('admin.reservas.assignTable');
    Route::delete('/reservas/{id}', [ReservaController::class, 'destroy'])->name('admin.reservas.destroy');

    // 🍔 CRUD Maestro de Platos (Avance 4)
    Route::get('/productos', [AdminProductoController::class, 'index'])->name('admin.productos.index');
    Route::get('/productos/create', [AdminProductoController::class, 'create'])->name('admin.productos.create');
    Route::post('/productos', [AdminProductoController::class, 'store'])->name('admin.productos.store');
    Route::get('/productos/{id}/edit', [AdminProductoController::class, 'edit'])->name('admin.productos.edit');
    Route::put('/productos/{id}', [AdminProductoController::class, 'update'])->name('admin.productos.update');
    Route::delete('/productos/{id}', [AdminProductoController::class, 'destroy'])->name('admin.productos.destroy');
    Route::patch('/productos/{id}/toggle-stock', [AdminProductoController::class, 'toggleStock'])->name('admin.productos.toggleStock');

    // 📊 Reportes Ejecutivos & Exportación (Avance 4 - REQ-AV4-03)
    Route::get('/reservas/exportar/csv', [ReporteController::class, 'exportarReservasCsv'])->name('admin.reservas.exportCsv');
    Route::get('/reservas/reporte/hoja-servicio-pdf', [ReporteController::class, 'hojaServicioPdf'])->name('admin.reservas.hojaServicioPdf');
    Route::get('/productos/reporte/inventario-pdf', [ReporteController::class, 'inventarioPlatosPdf'])->name('admin.productos.inventarioPdf');
});
