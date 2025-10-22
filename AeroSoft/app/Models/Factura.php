<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';
    protected $primaryKey = 'id_factura';
    public $timestamps = false;

    protected $fillable = ['id_compra', 'codigo'];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'id_compra');
    }
}
