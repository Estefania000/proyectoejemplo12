<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $fillable = [
        'nombre', 'n_cuenta', 'aula', 'tel', 
        'unidad_aprendizaje', 'profesor', 'licenciatura', 
        'fecha_solicitud', 'fecha_entrega', 'estatus'
    ];

    public function insumos()
    {
        return $this->belongsToMany(Insumo::class, 'prestamo_insumo')
                    ->withPivot('numero_insumo', 'estatus')
                    ->withTimestamps();
    }
}
