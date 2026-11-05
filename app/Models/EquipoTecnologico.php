<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipoTecnologico extends Model
{
    use HasFactory;

    protected $table = 'equipos_tecnologicos';

    protected $fillable = [
        'codigo',
        'tipo',
        'marca',
        'modelo',
        'numero_serie',
        'estado',
        'ubicacion',
        'observaciones',
    ];

    /**
     * Préstamos realizados de este equipo.
     */
    public function prestamos(): HasMany
    {
        return $this->hasMany(
            PrestamoEquipo::class,
            'equipo_id'
            
        );
        
    }
public function reservaciones(): HasMany
{
    return $this->hasMany(
        ReservacionEquipo::class,
        'equipo_id'
    );
}
}