<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\AsignacionMateriaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\TutoriaController;
use App\Http\Controllers\GrupoController;

use App\Models\Horario;
use App\Models\AsignacionMateria;
use App\Models\Aula;

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| PÁGINA PRINCIPAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    /*
    |--------------------------------------------------------------------------
    | Horarios registrados
    |--------------------------------------------------------------------------
    */

    $horarios = Horario::with([
        'asignacionMateria.docente',
        'asignacionMateria.materia',
        'asignacionMateria.grupo',
        'aula'
    ])
        ->orderBy('hora_inicio')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Asignaciones disponibles
    |--------------------------------------------------------------------------
    */

    $asignaciones = AsignacionMateria::with([
        'docente',
        'materia',
        'grupo',
        'cicloEscolar'
    ])
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Aulas disponibles
    |--------------------------------------------------------------------------
    */

    $aulas = Aula::where('disponible', true)
        ->orderBy('nombre')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Mostrar dashboard
    |--------------------------------------------------------------------------
    */

    return view('dashboard', compact(
        'horarios',
        'asignaciones',
        'aulas'
    ));

})->middleware(['auth'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

/*
|--------------------------------------------------------------------------
| GESTIÓN DE GRUPOS
|--------------------------------------------------------------------------
*/

Route::resource(
    'grupos',
    GrupoController::class
);
    /*
    |--------------------------------------------------------------------------
    | PERFIL
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE ALUMNOS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'alumnos',
        AlumnoController::class
    );


    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE MATERIAS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'materias',
        MateriaController::class
    );


    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE DOCENTES
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'docentes',
        DocenteController::class
    );


    /*
    |--------------------------------------------------------------------------
    | ASIGNACIÓN DE MATERIAS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'asignaciones_materias',
        AsignacionMateriaController::class
    );


    /*
    |--------------------------------------------------------------------------
    | HORARIOS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'horarios',
        HorarioController::class
    );


    /*
    |--------------------------------------------------------------------------
    | AULAS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'aulas',
        AulaController::class
    );


    /*
    |--------------------------------------------------------------------------
    | CALIFICACIONES
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/calificaciones',
        [CalificacionController::class, 'index']
    )->name('calificaciones.index');

    Route::post(
        '/calificaciones',
        [CalificacionController::class, 'store']
    )->name('calificaciones.store');

    Route::get(
        '/calificaciones/boleta/{alumno}',
        [CalificacionController::class, 'boleta']
    )->name('calificaciones.boleta');


    /*
    |--------------------------------------------------------------------------
    | INCIDENCIAS Y TUTORÍAS
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | HISTORIAL DEL ALUMNO
    |--------------------------------------------------------------------------
    |
    | Aquí podremos consultar todo el seguimiento del alumno:
    |
    | - Datos personales
    | - Grupo
    | - Incidencias
    | - Tutorías
    | - Seguimiento de incidencias
    |
    | Ejemplo:
    |
    | /incidencias/alumno/2/historial
    |
    */

    Route::get(
        '/incidencias/alumno/{alumno}/historial',
        [IncidenciaController::class, 'historial']
    )->name('incidencias.historial');


    /*
    |--------------------------------------------------------------------------
    | INCIDENCIAS
    |--------------------------------------------------------------------------
    |
    | GET       /incidencias
    | GET       /incidencias/create
    | POST      /incidencias
    | GET       /incidencias/{incidencia}
    | GET       /incidencias/{incidencia}/edit
    | PUT       /incidencias/{incidencia}
    | PATCH     /incidencias/{incidencia}
    | DELETE    /incidencias/{incidencia}
    |
    */

    Route::resource(
        'incidencias',
        IncidenciaController::class
    );


    /*
    |--------------------------------------------------------------------------
    | TUTORÍAS
    |--------------------------------------------------------------------------
    |
    | GET       /tutorias
    | GET       /tutorias/create
    | POST      /tutorias
    | GET       /tutorias/{tutoria}
    | GET       /tutorias/{tutoria}/edit
    | PUT       /tutorias/{tutoria}
    | PATCH     /tutorias/{tutoria}
    | DELETE    /tutorias/{tutoria}
    |
    */

    Route::resource(
        'tutorias',
        TutoriaController::class
    );

});


/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';