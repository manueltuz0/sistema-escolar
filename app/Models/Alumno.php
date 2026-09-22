<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';

    protected $fillable = [
        'matricula',
        'nombres',
        'apellidos',
        'email',
        'grupo_id',
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}