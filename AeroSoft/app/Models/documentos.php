<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class documentos extends Model
{
    protected $table = 'documentos';
    protected $primaryKey = 'id_td';
    public $timestamps = false;

    protected $fillable = ['Documento'];
}
