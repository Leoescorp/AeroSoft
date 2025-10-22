<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAvion extends Model
{

    protected $table = 'tipo_avion';
    protected $primaryKey = 'id_tipo_avion';
    public $timestamps = false;

    protected $fillable = ['Tipo_Avion'];

    public function vuelos() {
        return $this->hasMany(Vuelo::class, 'id_tipo_avion');
    }
}
