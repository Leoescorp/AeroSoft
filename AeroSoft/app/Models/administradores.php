<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class administradores extends Authenticatable
{
    protected $table = 'administradores';
    protected $primaryKey = 'id_administrador';
    public $timestamps = false;

    protected $fillable = [
        'Nombres',
        'Primer_Apellido',
        'Segundo_Apellido',
        'Fecha_Nacimiento',
        'id_genero',
        'id_td',
        'N_Documento',
        'Celular',
        'id_rol',
        'Correo',
        'Password',
        'Activida'
    ];

    protected $hidden = ['Password'];

    public function getAuthPassword(){
        return $this->Password;
    }

    public function TD() {
        return $this->belongsTo(documentos::class, 'id_td', 'id_td');
    }

    public function Genero() {
        return $this->belongsTo(generos::class, 'id_genero', 'id_genero');
    }

    public function ROL() {
        return $this->belongsTo(roles::class, 'id_rol', 'id_rol');
    }
}
