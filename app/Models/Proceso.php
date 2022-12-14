<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Proceso extends Model
{
    use HasFactory;
    public $table = 'procesos';

    protected $appends = [
        'image_uri'
    ];

    public function imageUri(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => Storage::url("public/procesos/" . $attributes['image']),
        );
    }
}
