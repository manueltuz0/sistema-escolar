<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incidencia extends Model
{
    use HasFactory;

    protected $table = 'incidencias';

    protected $fillable = [
        'alumno_id',
        'fecha',
        'tipo',
        'descripcion',
        'estado',
        'lugar',
        'acciones_realizadas',
        'observaciones',
    ];

    /**
     * Una incidencia pertenece a un alumno.
     */
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }
}
