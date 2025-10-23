<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';
    protected $primaryKey = 'id_compra';
    public $timestamps = false;

    protected $fillable = ['id_reserva', 'id_metodo_pago', 'Tarjeta', 'Monto_Total'];

    public function reserva() {
        return $this->belongsTo(Reserva::class, 'id_reserva');
    }

    public function metodoPago() {
        return $this->belongsTo(MetodoPago::class, 'id_metodo_pago');
    }
}