<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VueloController;
use Illuminate\Support\Facades\Route;

Route::get('/', [VueloController::class, 'index'])->name('vuelos.index');
Route::post('/buscar-vuelos', [VueloController::class, 'buscar'])->name('vuelos.buscar');
Route::get('/vuelos/{id}/seleccionar-tiquete', [VueloController::class, 'seleccionarTiquete'])->name('vuelos.seleccionar-tiquete');
Route::get('/vuelos/{id}/asientos', [VueloController::class, 'asientos'])->name('vuelos.asientos');
Route::get('/vuelos/{id}/reservar', [VueloController::class, 'reservar'])->name('vuelos.reservar');
Route::post('/vuelos/guardar-reserva', [VueloController::class, 'guardarReserva'])->name('vuelos.guardarReserva');

Route::get('/confirmacion-pago', [VueloController::class, 'confirmacionPago'])->name('vuelos.confirmacion-pago');
Route::post('/procesar-pago', [VueloController::class, 'procesarPago'])->name('vuelos.procesarPago');
Route::get('/compra-completada', [VueloController::class, 'compraCompletada'])->name('vuelos.compra-completada');

Route::get('/login', [LoginController::class, 'MostrarLogin'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [LoginController::class, 'Login'])->name('loguear');
Route::post('/logout', [LoginController::class, 'Logout'])->name('logout');

Route::middleware(['auth', 'Prevenir'])->group(function() {
    Route::prefix('admin')->group(function() {
        Route::get('/index', [AdminController::class, 'Index'])->name('admin.index');
        Route::get('/lista', [AdminController::class, 'ListaEditor'])->name('admin.lista');
        Route::get('/registrar', [AdminController::class, 'Registrar'])->name('admin.registrar');
        Route::post('/registro', [AdminController::class, 'Registro'])->name('admin.registro');
        Route::get('/editar/{id}', [AdminController::class, 'Editar'])->name('admin.editar');
        Route::post('/actualizar', [AdminController::class, 'Actualizar'])->name('admin.actualizar');
        Route::get('/cambiar-estado/{id}', [AdminController::class, 'CambiarEstado'])->name('admin.cambiar-estado');
    });
});