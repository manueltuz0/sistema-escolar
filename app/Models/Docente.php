<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docentes';

    protected $fillable = [
        'numero_empleado',
        'nombres',
        'apellidos',
        'email',
        'telefono',
        'especialidad',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | ASIGNACIONES DE MATERIAS
    |--------------------------------------------------------------------------
    */

    public function asignacionesMaterias(): HasMany
    {
        return $this->hasMany(AsignacionMateria::class, 'docente_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACTIVIDADES GRUPALES DE TUTORÍA
    |--------------------------------------------------------------------------
    */

    public function actividadesTutorias(): HasMany
    {
        return $this->hasMany(ActividadTutoria::class, 'docente_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ATENCIONES INDIVIDUALES DE TUTORÍA
    |--------------------------------------------------------------------------
    */

    public function tutorias(): HasMany
    {
        return $this->hasMany(Tutoria::class, 'docente_id');
    }
}


