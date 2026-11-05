<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservacionEquipo extends Model
{
    use HasFactory;

    protected $table = 'reservaciones_equipos';

    protected $fillable = [
        'equipo_id',
        'docente_id',
        'alumno_id',
        'materia_id',
        'semestre',
        'fecha_inicio',
        'hora_inicio',
        'fecha_fin',
        'hora_fin',
        'estado',
        'solicitado_por_user_id',
        'autorizado_por_user_id',
        'autorizado_at',
        'cancelado_por_user_id',
        'cancelado_at',
        'prestamo_equipo_id',
        'observaciones',
        'motivo_rechazo',
        'motivo_cancelacion',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'autorizado_at' => 'datetime',
        'cancelado_at' => 'datetime',
        'semestre' => 'integer',
        
    ];

public function movimientos()
{
    return $this->hasMany(
        MovimientoPrestamo::class,
        'reservacion_equipo_id'
    );
}

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(EquipoTecnologico::class, 'equipo_id');
    }

    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function solicitadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'solicitado_por_user_id');
    }

    public function autorizadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'autorizado_por_user_id');
    }

    public function canceladoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cancelado_por_user_id');
    }

    public function prestamo(): BelongsTo
    {
        return $this->belongsTo(PrestamoEquipo::class, 'prestamo_equipo_id');
    }
}
