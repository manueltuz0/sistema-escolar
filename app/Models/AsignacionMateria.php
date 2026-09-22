<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionMateria extends Model
{
    use HasFactory;

    protected $table = 'asignaciones_materias';

    protected $fillable = [
        'docente_id',
        'materia_id',
        'grupo_id',
        'ciclo_escolar_id',
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    public function cicloEscolar()
    {
        return $this->belongsTo(CicloEscolar::class, 'ciclo_escolar_id');
    }
}