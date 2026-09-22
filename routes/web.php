<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\AsignacionMateriaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\AulaController;

use App\Models\Horario;
use App\Models\AsignacionMateria;
use App\Models\Aula;

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Página principal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    // Horarios registrados
    $horarios = Horario::with([
        'asignacionMateria.docente',
        'asignacionMateria.materia',
        'asignacionMateria.grupo',
        'aula'
    ])
    ->orderBy('hora_inicio')
    ->get();


    // Asignaciones disponibles para registrar horarios
    $asignaciones = AsignacionMateria::with([
        'docente',
        'materia',
        'grupo',
        'cicloEscolar'
    ])
    ->get();


    // Aulas disponibles
    $aulas = Aula::where('disponible', true)
        ->orderBy('nombre')
        ->get();


    return view('dashboard', compact(
        'horarios',
        'asignaciones',
        'aulas'
    ));

})->middleware(['auth'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Rutas protegidas
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Perfil
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | Gestión de Alumnos
    |--------------------------------------------------------------------------
    */

    Route::resource('alumnos', AlumnoController::class);


    /*
    |--------------------------------------------------------------------------
    | Gestión de Materias
    |--------------------------------------------------------------------------
    */

    Route::resource('materias', MateriaController::class);


    /*
    |--------------------------------------------------------------------------
    | Gestión de Docentes
    |--------------------------------------------------------------------------
    */

    Route::resource('docentes', DocenteController::class);


    /*
    |--------------------------------------------------------------------------
    | Asignación de Materias
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'asignaciones_materias',
        AsignacionMateriaController::class
    );


    /*
    |--------------------------------------------------------------------------
    | Horarios
    |--------------------------------------------------------------------------
    */

    Route::resource('horarios', HorarioController::class);


    /*
    |--------------------------------------------------------------------------
    | Aulas
    |--------------------------------------------------------------------------
    */

    Route::resource('aulas', AulaController::class);

});


/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';