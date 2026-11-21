<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'oferta',
        'stock',
        'categoria_id',
        'color_id',
        'talla_id',
        'imagen',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categorias::class, 'categoria_id');
    }

    public function color()
    {
        return $this->belongsTo(Colores::class, 'color_id');
    }

    public function talla()
    {
        return $this->belongsTo(Talla::class, 'talla_id');
    }
}
