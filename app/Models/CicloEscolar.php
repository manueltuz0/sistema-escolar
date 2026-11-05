<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CicloEscolar extends Model
{
    use HasFactory;

    protected $table = 'ciclos_escolares';

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'activo',
    ];

    /*
    |--------------------------------------------------------------------------
    | ASIGNACIONES DE MATERIAS
    |--------------------------------------------------------------------------
    */

    public function asignacionesMaterias()
    {
        return $this->hasMany(
            AsignacionMateria::class,
            'ciclo_escolar_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACTIVIDADES GRUPALES DE TUTORÍA
    |--------------------------------------------------------------------------
    */

    public function actividadesTutorias()
    {
        return $this->hasMany(
            ActividadTutoria::class,
            'ciclo_escolar_id'
        );
    }
}
