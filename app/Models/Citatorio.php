<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Citatorio extends Model
{
    protected $table = 'citatorios';

    protected $fillable = [
        'alumno_id',
        'responsable_alumno_id',
        'responsable_nombre',
        'responsable_parentesco',
        'responsable_email',
        'responsable_telefono',
        'motivo',
        'fecha_emision',
        'fecha_cita',
        'hora_cita',
        'observaciones',
        'estado',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'fecha_cita' => 'date',
    ];

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class);
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(
            ResponsableAlumno::class,
            'responsable_alumno_id'
        );
    }

    public function notificaciones(): HasMany
    {
        return $this->hasMany(
            NotificacionCitatorio::class,
            'citatorio_id'
        );
    }
}
