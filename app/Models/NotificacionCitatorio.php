<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificacionCitatorio extends Model
{
    use HasFactory;

    protected $table = 'notificaciones_citatorios';

    protected $fillable = [
        'citatorio_id',
        'medio',
        'telefono',
        'mensaje',
        'estado',
        'fecha_intento',
        'observaciones',
    ];

    protected $casts = [
        'fecha_intento' => 'datetime',
    ];

    public function citatorio(): BelongsTo
    {
        return $this->belongsTo(Citatorio::class, 'citatorio_id');
    }
}
