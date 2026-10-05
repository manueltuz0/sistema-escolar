<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tutoria extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | TABLA
    |--------------------------------------------------------------------------
    */

    protected $table = 'tutorias';


    /*
    |--------------------------------------------------------------------------
    | CAMPOS
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'alumno_id',

        'incidencia_id',

        'fecha',

        'tipo',

        'motivo',

        'situacion',

        'acuerdos',

        'compromisos_alumno',

        'compromisos_tutor',

        'fecha_seguimiento',

        'estado',

        'observaciones',

    ];


    /*
    |--------------------------------------------------------------------------
    | ALUMNO
    |--------------------------------------------------------------------------
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
    | INCIDENCIA
    |--------------------------------------------------------------------------
    */

    public function incidencia()
    {
        return $this->belongsTo(
            Incidencia::class,
            'incidencia_id'
        );
    }
}