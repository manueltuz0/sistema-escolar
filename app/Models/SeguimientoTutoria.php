<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeguimientoTutoria extends Model
{
    use HasFactory;

    protected $table = 'seguimientos_tutorias';

    protected $fillable = [
        'tutoria_id',
        'fecha_programada',
        'fecha_realizada',
        'resultado',
        'acuerdos',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'fecha_programada' => 'date',
        'fecha_realizada' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | ATENCIÓN INDIVIDUAL
    |--------------------------------------------------------------------------
    */

    public function tutoria()
    {
        return $this->belongsTo(Tutoria::class, 'tutoria_id');
    }
}
