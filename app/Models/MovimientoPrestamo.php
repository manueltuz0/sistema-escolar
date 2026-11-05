<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoPrestamo extends Model
{
    use HasFactory;

    protected $table = 'movimientos_prestamos';

    protected $fillable = [
        'prestamo_equipo_id',
        'reservacion_equipo_id',
        'user_id',
        'tipo_movimiento',
        'estado_anterior',
        'estado_nuevo',
        'descripcion',
        'observaciones',
    ];

    public function prestamo(): BelongsTo
    {
        return $this->belongsTo(
            PrestamoEquipo::class,
            'prestamo_equipo_id'
        );
    }

    public function reservacion(): BelongsTo
    {
        return $this->belongsTo(
            ReservacionEquipo::class,
            'reservacion_equipo_id'
        );
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}
