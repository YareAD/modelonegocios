<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasoUsoRequerimiento extends Model
{
    use HasFactory;
    public $table = "casos_de_uso_requerimientos";
    public $timestamps = false;


    public function requerimiento()
    {
        return $this->hasOne(Requerimiento::class, 'id', 'requerimiento_id');
    }
}
