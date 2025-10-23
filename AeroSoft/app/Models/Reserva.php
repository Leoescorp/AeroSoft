<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';
    protected $primaryKey = 'id_reserva';
    public $timestamps = false;

    protected $fillable = [
        'id_vuelo', 'id_vuelo_regreso', 'id_asiento', 'Precio_Final',
        'Nombres_Cliente', 'Primer_Apellido_Cliente', 'Segundo_Apellido_Cliente',
        'Fecha_Nacimiento', 'id_genero', 'id_td', 'N_Documento',
        'Celular', 'Correo', 'Acompañante', 'id_tipo_tiquete',
        'es_acompañante', 'orden_pasajero', 'id_reserva_principal'
    ];

    protected $casts = [
        'Precio_Final' => 'decimal:2',
        'Fecha_Nacimiento' => 'date',
        'Acompañante' => 'boolean',
        'es_acompañante' => 'boolean'
    ];

    public function vuelo() {
        return $this->belongsTo(Vuelo::class, 'id_vuelo');
    }

    public function vueloRegreso() {
        return $this->belongsTo(VueloRegreso::class, 'id_vuelo_regreso');
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

    public function tipoTiquete() {
        return $this->belongsTo(TipoTiquete::class, 'id_tipo_tiquete');
    }

    public function reservaPrincipal() {
        return $this->belongsTo(Reserva::class, 'id_reserva_principal');
    }

    public function acompañantes() {
        return $this->hasMany(Reserva::class, 'id_reserva_principal');
    }

    public function compra() {
        return $this->hasOne(Compra::class, 'id_reserva');
    }
}