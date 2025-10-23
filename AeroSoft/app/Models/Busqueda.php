<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Busqueda extends Model
{
    protected $table = 'busquedas';
    protected $primaryKey = 'id_busqueda';
    public $timestamps = false;

    protected $fillable = [
        'tipo_vuelo',
        'Origen', 
        'Destino',
        'Fecha_ida',
        'Fecha_ida_vuelta',
        'Pasajeros',
        'num_tiquetes'
    ];

    protected $casts = [
        'tipo_vuelo' => 'string',
        'Fecha_ida' => 'date',
        'Fecha_ida_vuelta' => 'date'
    ];

    public function vuelos() {
        return $this->hasMany(Vuelo::class, 'id_busqueda');
    }
}