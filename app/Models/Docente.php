<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];
}