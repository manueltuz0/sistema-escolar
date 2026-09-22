<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';

    protected $fillable = [
        'asignacion_materia_id',
        'aula_id',
        'dia',
        'hora_inicio',
        'hora_fin',
    ];

    public function asignacionMateria()
    {
        return $this->belongsTo(
            AsignacionMateria::class,
            'asignacion_materia_id'
        );
    }

    public function aula()
    {
        return $this->belongsTo(
            Aula::class,
            'aula_id'
        );
    }
}