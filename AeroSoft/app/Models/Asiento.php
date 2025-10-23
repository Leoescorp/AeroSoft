<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asiento extends Model
{
    protected $table = 'asientos';
    protected $primaryKey = 'id_asiento';
    public $timestamps = false;

    protected $fillable = ['Asiento', 'Disponibilidad'];

    public function vueloAsientos() {
        return $this->hasMany(VueloAsiento::class, 'id_asiento');
    }
}
