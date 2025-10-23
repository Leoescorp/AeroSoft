<?php

use App\Http\Controllers\AdminControl;
use App\Http\Controllers\LoginControl;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/Login', [LoginControl::class, 'MostrarLogin'])
    ->name('login')
    ->middleware('Prevenir');

Route::post('/Login/Login', [LoginControl::class, 'Login'])->name('loguear');

Route::post('/Logout', [LoginControl::class, 'Logout'])
    ->name('logout')
    ->middleware('Prevenir');
Route::get('/tickets', function () {
    return view('tickets');
})->name('tickets');

Route::middleware(['auth','Prevenir'])->group(function() {
    Route::middleware('rol:1')->get('/Admin/Index', [AdminControl::class, 'Index'])->name('admin_index');
    Route::middleware('rol:1')->get('/Admin/Lista', [AdminControl::class, 'ListaEditor'])->name('admin_lista');
    Route::middleware('rol:1')->get('/Admin/Registrar', [AdminControl::class, 'Registrar'])->name('admin_registrar');
    Route::middleware('rol:1')->post('/Admin/Registro', [AdminControl::class, 'Registro'])->name('admin_registro');
});