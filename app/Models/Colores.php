<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colores extends Model
{
    protected $table = 'colores';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];
}
