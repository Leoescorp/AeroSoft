<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoTiquete extends Model
{
    protected $table = 'tipo_tiquete';
    protected $primaryKey = 'id_tipo_tiquete';
    public $timestamps = false;

    protected $fillable = ['tipo_tiquete', 'Porcentaje', 'Beneficios'];

    protected $casts = [
        'Porcentaje' => 'decimal:2'
    ];

    public function vuelos() {
        return $this->hasMany(Vuelo::class, 'id_tipo_tiquete');
    }

    public function reservas() {
        return $this->hasMany(Reserva::class, 'id_tipo_tiquete');
    }
}