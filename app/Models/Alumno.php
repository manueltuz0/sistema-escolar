<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';

    protected $fillable = [
        'matricula',
        'nombres',
        'apellidos',
        'email',
        'grupo_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | GRUPO
    |--------------------------------------------------------------------------
    */

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    /*
    |--------------------------------------------------------------------------
    | INCIDENCIAS
    |--------------------------------------------------------------------------
    */

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }

    /*
    |--------------------------------------------------------------------------
    | TUTORÍAS INDIVIDUALES
    |--------------------------------------------------------------------------
    */

    public function tutorias()
    {
        return $this->hasMany(Tutoria::class, 'alumno_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACTIVIDADES GRUPALES DE TUTORÍA
    |--------------------------------------------------------------------------
    */

    public function actividadesTutorias()
    {
        return $this->belongsToMany(
            ActividadTutoria::class,
            'actividad_tutoria_alumno',
            'alumno_id',
            'actividad_tutoria_id'
        )->withPivot('asistencia', 'observaciones')
         ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | RESPONSABLES DEL ALUMNO
    |--------------------------------------------------------------------------
    */

    public function responsables()
    {
        return $this->hasMany(ResponsableAlumno::class, 'alumno_id');
    }
}
