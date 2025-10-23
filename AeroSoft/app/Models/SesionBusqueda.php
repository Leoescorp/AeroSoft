<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesionBusqueda extends Model
{
    protected $table = 'sesiones_busqueda';
    protected $primaryKey = 'id_sesion';
    public $timestamps = false;

    protected $fillable = [
        'id_sesion',
        'datos_busqueda',
        'fecha_creacion',
        'fecha_expiracion'
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_expiracion' => 'datetime'
    ];
}