<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResponsableAlumno extends Model
{
    use HasFactory;

    protected $table = 'responsables_alumnos';

    protected $fillable = [
        'alumno_id',
        'nombre',
        'parentesco',
        'email',
        'telefono',
        'es_principal',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }
}