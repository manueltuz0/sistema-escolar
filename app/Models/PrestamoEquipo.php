<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrestamoEquipo extends Model
{
    use HasFactory;

    protected $table = 'prestamos_equipos';

    protected $fillable = [
        'equipo_id',
        'fecha_prestamo',
        'hora_prestamo',
        'docente_id',
        'alumno_id',
        'materia_id',
        'semestre',
        'fecha_devolucion',
        'hora_devolucion',
        'estado',
        'condicion_entrega',
        'condicion_devolucion',
        'responsable_entrega',
        'responsable_recepcion',
        'observaciones',
    ];

    protected $casts = [
        'fecha_prestamo' => 'date',
        'fecha_devolucion' => 'date',
        'semestre' => 'integer',
    ];

    /**
     * Equipo tecnológico prestado.
     */
    public function equipo(): BelongsTo
    {
        return $this->belongsTo(
            EquipoTecnologico::class,
            'equipo_id'
        );
    }

    /**
     * Docente que solicita el equipo.
     */
    public function docente(): BelongsTo
    {
        return $this->belongsTo(
            Docente::class,
            'docente_id'
        );
    }
    
public function reservacion()
{
    return $this->hasOne(
        ReservacionEquipo::class,
        'prestamo_equipo_id'
    );
}

public function movimientos()
{
    return $this->hasMany(
        MovimientoPrestamo::class,
        'prestamo_equipo_id'
    );
}

    /**
     * Alumno relacionado con el préstamo.
     */
    public function alumno(): BelongsTo
    {
        return $this->belongsTo(
            Alumno::class,
            'alumno_id'
        );
    }

    /**
     * Materia relacionada con el préstamo.
     */
    public function materia(): BelongsTo
    {
        return $this->belongsTo(
            Materia::class,
            'materia_id'
        );
    }
}
