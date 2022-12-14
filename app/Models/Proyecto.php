<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'responsable',
    ];

    public function requerimientos()
    {
        return $this->hasMany(Requerimiento::class, 'proyecto', 'id');
        # code...
    }

    public function casosUso()
    {
        return $this->hasMany(CasosUso::class, 'proyecto', 'id');
    }
}
