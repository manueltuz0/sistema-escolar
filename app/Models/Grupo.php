<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grupo extends Model
{
    protected $fillable = [
        'nombre',
        'grado',
        'especialidad',
        'ciclo_escolar_id',
    ];

    protected $casts = [
        'grado' => 'integer',
    ];

    /**
     * Un grupo pertenece a un ciclo escolar.
     */
    public function cicloEscolar(): BelongsTo
    {
        return $this->belongsTo(CicloEscolar::class);
    }

    /**
     * Un grupo puede tener muchos alumnos.
     */
    public function alumnos(): HasMany
    {
        return $this->hasMany(Alumno::class);
    }

    /**
     * Un grupo puede tener muchas asignaciones de materias.
     */
    public function asignacionesMaterias(): HasMany
    {
        return $this->hasMany(AsignacionMateria::class);
    }
}