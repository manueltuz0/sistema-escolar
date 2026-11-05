<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActividadTutoria extends Model
{
    use HasFactory;

    protected $table = 'actividades_tutorias';

    protected $fillable = [
        'docente_id',
        'grupo_id',
        'ciclo_escolar_id',
        'fecha',
        'tema',
        'tipo',
        'descripcion',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | DOCENTE RESPONSABLE
    |--------------------------------------------------------------------------
    */

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    /*
    |--------------------------------------------------------------------------
    | GRUPO
    |--------------------------------------------------------------------------
    */

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    /*
    |--------------------------------------------------------------------------
    | CICLO ESCOLAR
    |--------------------------------------------------------------------------
    */

    public function cicloEscolar()
    {
        return $this->belongsTo(CicloEscolar::class, 'ciclo_escolar_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ALUMNOS PARTICIPANTES
    |--------------------------------------------------------------------------
    */

    public function alumnos()
    {
        return $this->belongsToMany(
            Alumno::class,
            'actividad_tutoria_alumno',
            'actividad_tutoria_id',
            'alumno_id'
        )->withPivot('asistencia', 'observaciones')
         ->withTimestamps();
    }
}
