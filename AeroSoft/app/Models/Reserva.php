<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';
    protected $primaryKey = 'id_reserva';
    public $timestamps = false;

    protected $fillable = [
        'id_vuelo', 'id_asiento', 'Precio_Final',
        'Nombres_Cliente', 'Primer_Apellido_Cliente', 'Segundo_Apellido_Cliente',
        'Fecha_Nacimiento', 'id_genero', 'id_td', 'N_Documento',
        'Celular', 'Correo', 'Acompañante'
    ];

    public function vuelo() {
        return $this->belongsTo(Vuelo::class, 'id_vuelo');
    }

    public function asiento() {
        return $this->belongsTo(Asiento::class, 'id_asiento');
    }

    public function genero() {
        return $this->belongsTo(generos::class, 'id_genero');
    }

    public function documento() {
        return $this->belongsTo(documentos::class, 'id_td');
    }
}
