<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';
    protected $primaryKey = 'id_compra';
    public $timestamps = false;

    protected $fillable = [
        'id_reserva', 
        'id_metodo_pago', 
        'Tarjeta', 
        'Monto_Total',
        'num_tiquetes'
    ];

    protected $casts = [
        'Monto_Total' => 'decimal:2'
    ];

    public function reserva() {
        return $this->belongsTo(Reserva::class, 'id_reserva');
    }

    public function metodoPago() {
        return $this->belongsTo(MetodoPago::class, 'id_metodo_pago');
    }

    public function factura() {
        return $this->hasOne(Factura::class, 'id_compra');
    }
}