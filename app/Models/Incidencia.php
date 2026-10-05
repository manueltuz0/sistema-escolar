<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incidencia extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | TABLA
    |--------------------------------------------------------------------------
    */

    protected $table = 'incidencias';


    /*
    |--------------------------------------------------------------------------
    | CAMPOS QUE SE PUEDEN ASIGNAR
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'alumno_id',

        'fecha',

        'tipo',

        'descripcion',

        'prioridad',

        'estado',

        'lugar',

        'acciones_realizadas',

        'observaciones',

    ];


    /*
    |--------------------------------------------------------------------------
    | ALUMNO
    |--------------------------------------------------------------------------
    |
    | Una incidencia pertenece a un alumno.
    |
    | incidencias.alumno_id
    |          ↓
    | alumnos.id
    |
    */

    public function alumno()
    {
        return $this->belongsTo(
            Alumno::class,
            'alumno_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TUTORÍAS
    |--------------------------------------------------------------------------
    |
    | Una incidencia puede tener una o varias tutorías.
    |
    | Ejemplo:
    |
    | Incidencia
    |    ↓
    | Tutoría 1
    |    ↓
    | Tutoría 2
    |    ↓
    | Tutoría 3
    |
    | Esto permite llevar el seguimiento del alumno.
    |
    */

    public function tutorias()
    {
        return $this->hasMany(
            Tutoria::class,
            'incidencia_id'
        );
    }
}