<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodoEvaluacion extends Model
{
    protected $table = 'periodos_evaluacion';

    protected $fillable = [
        'nombre',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }
}