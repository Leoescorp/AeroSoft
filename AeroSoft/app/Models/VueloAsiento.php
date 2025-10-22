<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VueloAsiento extends Model
{

    protected $table = 'vuelo_asiento';
    protected $primaryKey = 'id_vuelo_asiento';
    public $timestamps = false;

    protected $fillable = ['id_vuelo', 'id_asiento', 'Disponible'];

    public function vuelo() {
        return $this->belongsTo(Vuelo::class, 'id_vuelo');
    }

    public function asiento() {
        return $this->belongsTo(Asiento::class, 'id_asiento');
    }
}
