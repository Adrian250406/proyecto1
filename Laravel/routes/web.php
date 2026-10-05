<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| 1. RUTAS PÚBLICAS (Para todos los clientes)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/menu', function () {
    return view('Menu');
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
    Route::get('/reservas', [ReservaController::class, 'index'])->name('admin.reservas.index');
    Route::put('/reservas/{id}/status', [ReservaController::class, 'updateStatus'])->name('admin.reservas.updateStatus');
});
