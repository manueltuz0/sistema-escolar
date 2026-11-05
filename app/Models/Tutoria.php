<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tutoria extends Model
{
    use HasFactory;

    protected $table = 'tutorias';

    protected $fillable = [
        'alumno_id',
        'docente_id',
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

    protected $casts = [
        'fecha' => 'date',
        'fecha_seguimiento' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    // Alumno atendido
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    // Docente que realizó la atención
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    // Seguimientos de esta atención individual
    public function seguimientos()
    {
        return $this->hasMany(SeguimientoTutoria::class, 'tutoria_id')
            ->orderBy('fecha_programada');
    }
}
