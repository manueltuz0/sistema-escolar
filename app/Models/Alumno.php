<?php

namespace App\Models;

use HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    

    protected $table = 'alumnos';

    protected $fillable = [
        'matricula',
        'nombres',
        'apellidos',
        'email',
        'grupo_id',
    ];

    /**
     * Grupo al que pertenece el alumno.
     */
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    /**
     * Incidencias registradas del alumno.
     */
    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }

    /**
     * Tutorías registradas del alumno.
     */
    public function tutorias()
    {
        return $this->hasMany(Tutoria::class);
    }
}