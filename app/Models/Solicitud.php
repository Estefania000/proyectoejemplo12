<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';

    protected $fillable = [
    'nombre',
    'n_cuenta',
    'aula',
    'tel',               // <-- agregar esta línea
    'unidad_aprendizaje',
    'profesor',
    'licenciatura',
    'fecha_entrega', // Se asignará por el administrador
    ];


    public function insumos()
    {
        return $this->hasMany(SInsumo::class, 'solicitud_id');
    }
}
