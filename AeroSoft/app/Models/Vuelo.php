<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vuelo extends Model
{
    protected $table = 'vuelos';
    protected $primaryKey = 'id_vuelo';
    public $timestamps = false;

    protected $fillable = [
        'id_busqueda', 'Origen', 'Destino', 'Fecha_Salida', 'Hora_Salida',
        'Duracion', 'Cupo', 'N_Avion', 'id_tipo_avion', 'Precio',
        'id_tipo_tiquete', 'Estado'
    ];

    public function tipoAvion() {
        return $this->belongsTo(TipoAvion::class, 'id_tipo_avion');
    }

    public function tipoTiquete() {
        return $this->belongsTo(TipoTiquete::class, 'id_tipo_tiquete');
    }

    public function vueloAsientos() {
        return $this->hasMany(VueloAsiento::class, 'id_vuelo');
    }

    public function reservas() {
        return $this->hasMany(Reserva::class, 'id_vuelo');
    }
}