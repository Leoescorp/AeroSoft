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

    protected $casts = [
        'Fecha_Salida' => 'date',
        'Hora_Salida' => 'datetime:H:i',
        'Precio' => 'decimal:2',
        'Estado' => 'boolean'
    ];

    public function busqueda() {
        return $this->belongsTo(Busqueda::class, 'id_busqueda');
    }

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

    public function vuelosIda() {
        return $this->hasMany(VueloRegreso::class, 'id_vuelo_ida');
    }

    public function vuelosVuelta() {
        return $this->hasMany(VueloRegreso::class, 'id_vuelo_vuelta');
    }

    // Scope para vuelos disponibles
    public function scopeDisponibles($query) {
        return $query->where('Estado', 1);
    }

    // Calcular precio con tipo de tiquete
    public function calcularPrecioFinal($idTipoTiquete) {
        $tipoTiquete = TipoTiquete::find($idTipoTiquete);
        return $this->Precio + ($this->Precio * $tipoTiquete->Porcentaje / 100);
    }
}