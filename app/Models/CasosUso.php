<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasosUso extends Model
{
    use HasFactory;
    public $table = "casos_de_uso";


    public function pivot_requerimientos()
    {
        return $this->hasMany(CasoUsoRequerimiento::class, 'caso_de_uso_id', 'id');
    }

    public function requerimientos()
    {
        return $this->hasManyThrough(Requerimiento::class, CasoUsoRequerimiento::class, 'caso_de_uso_id', 'id', 'id', 'requerimiento_id');
    }
}
