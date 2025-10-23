<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VueloRegreso extends Model
{
    protected $table = 'vuelos_regreso';
    protected $primaryKey = 'id_vuelo_regreso';
    public $timestamps = false;

    protected $fillable = [
        'id_vuelo_ida',
        'id_vuelo_vuelta', 
        'precio_total'
    ];

    protected $casts = [
        'precio_total' => 'decimal:2'
    ];

    public function vueloIda() {
        return $this->belongsTo(Vuelo::class, 'id_vuelo_ida');
    }

    public function vueloVuelta() {
        return $this->belongsTo(Vuelo::class, 'id_vuelo_vuelta');
    }
}