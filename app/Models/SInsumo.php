<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SInsumo extends Model
{
    use HasFactory;

    protected $table = 's_insumos';

    protected $fillable = [
        'solicitud_id',
        'tipo',
        'numero_asignado',
        'estatus',
    ];

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'solicitud_id');
    }
}
