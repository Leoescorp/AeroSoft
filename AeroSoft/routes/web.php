<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\VueloController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   return view('Practica.Index');
});

Route::get('/Login', [LoginController::class, 'MostrarLogin'])
    ->name('login')
    ->middleware('Prevenir');

Route::post('/Login/Login', [LoginController::class, 'Login'])->name('loguear');

Route::post('/Logout', [LoginController::class, 'Logout'])
    ->name('logout')
    ->middleware('Prevenir');

Route::middleware(['auth','Prevenir'])->group(function() {
    Route::middleware('rol:1')->get('/Admin/Index', [AdminController::class, 'Index'])->name('admin_index');
    Route::middleware('rol:1')->get('/Admin/Lista', [AdminController::class, 'ListaEditor'])->name('admin_lista');
    Route::middleware('rol:1')->get('/Admin/Registrar', [AdminController::class, 'Registrar'])->name('admin_registrar');
    Route::middleware('rol:1')->post('/Admin/Registro', [AdminController::class, 'Registro'])->name('admin_registro');
});



Route::get('/busqueda', [VueloController::class, 'index'])->name('vuelos.index');
Route::get('/buscar-vuelos', [VueloController::class, 'buscar'])->name('vuelos.buscar');
Route::get('/vuelos/{id}/asientos', [VueloController::class, 'asientos'])->name('vuelos.asientos');
Route::get('/vuelos/{id}/reservar', [VueloController::class, 'reservar'])->name('vuelos.reservar');
Route::post('/vuelos/guardar-reserva', [VueloController::class, 'guardarReserva'])->name('vuelos.guardarReserva');
