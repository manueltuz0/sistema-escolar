<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificaciones';

    protected $fillable = [
        'alumno_id',
        'asignacion_materia_id',
        'periodo_evaluacion_id',
        'calificacion',
    ];

    protected $casts = [
        'calificacion' => 'decimal:2',
    ];

    /**
     * Alumno que recibe la calificación.
     */
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    /**
     * Asignación de materia:
     * docente + materia + grupo + ciclo escolar.
     */
    public function asignacionMateria()
    {
        return $this->belongsTo(
            AsignacionMateria::class,
            'asignacion_materia_id'
        );
    }

    /**
     * Periodo de evaluación.
     */
    public function periodoEvaluacion()
    {
        return $this->belongsTo(
            PeriodoEvaluacion::class,
            'periodo_evaluacion_id'
        );
    }
}