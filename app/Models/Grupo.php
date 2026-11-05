<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';

    protected $fillable = [
        'nombre',
        'grado',
        'especialidad',
        'ciclo_escolar_id',
    ];

    protected $casts = [
        'grado' => 'integer',
    ];

    public function cicloEscolar(): BelongsTo
    {
        return $this->belongsTo(CicloEscolar::class, 'ciclo_escolar_id');
    }

    public function alumnos(): HasMany
    {
        return $this->hasMany(Alumno::class, 'grupo_id');
    }

    public function asignacionesMaterias(): HasMany
    {
        return $this->hasMany(AsignacionMateria::class, 'grupo_id');
    }
}
