<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class generos extends Model
{
    protected $table = 'generos';
    protected $primaryKey = 'id_genero';
    public $timestamps = false;

    protected $fillable = ['Genero'];
}
