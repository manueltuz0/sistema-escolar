<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materias';

    protected $fillable = [
        'clave',
        'nombre',
        'horas_semana',
        'descripcion',
        'semestre',
        'activa',
    ];

    protected $casts = [
        'horas_semana' => 'integer',
        'semestre' => 'integer',
        'activa' => 'boolean',
    ];

    /**
     * Asignaciones de esta materia a docentes y grupos.
     */
    public function asignaciones(): HasMany
    {
        return $this->hasMany(AsignacionMateria::class, 'materia_id');
    }
}