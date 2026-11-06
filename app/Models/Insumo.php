<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $fillable = ['tipo', 'cantidad_disponible'];

    public function prestamos()
    {
        return $this->belongsToMany(Prestamo::class, 'prestamo_insumo')
                    ->withPivot('numero_insumo', 'estatus')
                    ->withTimestamps();
    }
}
