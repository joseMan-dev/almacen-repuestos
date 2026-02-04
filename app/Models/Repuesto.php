<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repuesto extends Model
{
    protected $fillable = [
        'referencia',
        'nombre',
        'descripcion',
        'categoria',
        'ubicacion',
        'stock_actual',
        'stock_minimo',
    ];
}
