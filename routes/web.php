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
use App\Http\Controllers\PrestamoEquipoController;
use App\Http\Controllers\EquipoTecnologicoController;
use App\Http\Controllers\ReservacionEquipoController;
use App\Http\Controllers\CitatorioController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// CONTROLADORES DE TUTORÍAS
use App\Http\Controllers\ActividadTutoriaController;
use App\Http\Controllers\SeguimientoTutoriaController;
use App\Http\Controllers\ExpedienteTutoriaController;

use App\Models\Horario;
use App\Models\AsignacionMateria;
use App\Models\Aula;

use Illuminate\Support\Facades\Route;

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
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
| DASHBOARD PRINCIPAL
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $horarios = Horario::with([
        'asignacionMateria.docente',
        'asignacionMateria.materia',
        'asignacionMateria.grupo',
        'aula',
    ])
        ->orderBy('hora_inicio')
        ->get();

    $asignaciones = AsignacionMateria::with([
        'docente',
        'materia',
        'grupo',
        'cicloEscolar',
    ])->get();

    $aulas = Aula::where('disponible', true)
        ->orderBy('nombre')
        ->get();

    return view('dashboard', compact(
        'horarios',
        'asignaciones',
        'aulas'
    ));

})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
     
Route::get(
    'prestamos_equipos/materias-por-docente/{id}',
    [PrestamoEquipoController::class, 'materiasPorDocente']
)->name('prestamos_equipos.materias_por_docente');
    /*
    |--------------------------------------------------------------------------
    | PERFIL
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
    | GESTIÓN DE ALUMNOS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/alumnos/exportar',
        [AlumnoController::class, 'exportar']
    )->name('alumnos.exportar');

    Route::post(
        '/alumnos/importar',
        [AlumnoController::class, 'importar']
    )->name('alumnos.importar');

    Route::resource('alumnos', AlumnoController::class);

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE GRUPOS
    |--------------------------------------------------------------------------
    */

    Route::resource('grupos', GrupoController::class);

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE MATERIAS
    |--------------------------------------------------------------------------
    */

    Route::resource('materias', MateriaController::class);

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE DOCENTES
    |--------------------------------------------------------------------------
    */

    Route::post(
        'docentes/importar',
        [DocenteController::class, 'importar']
    )->name('docentes.importar');

    Route::get(
        'docentes/exportar',
        [DocenteController::class, 'exportar']
    )->name('docentes.exportar');

    Route::get(
        'docentes/plantilla',
        [DocenteController::class, 'descargarPlantilla']
    )->name('docentes.plantilla');

    Route::resource('docentes', DocenteController::class);

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

    Route::get(
        '/horarios/captura-rapida',
        [HorarioController::class, 'capturaRapida']
    )->name('horarios.captura-rapida');

    Route::post(
        '/horarios/captura-rapida',
        [HorarioController::class, 'guardarCapturaRapida']
    )->name('horarios.guardar-captura-rapida');

    Route::get(
        '/horarios/grupo/{grupo}/imprimir',
        [HorarioController::class, 'imprimirGrupo']
    )->name('horarios.imprimir-grupo');

    Route::put(
        '/horarios/captura-rapida/{horario}',
        [HorarioController::class, 'actualizarCapturaRapida']
    )->name('horarios.captura-rapida.actualizar');

    Route::delete(
        '/horarios/captura-rapida/{horario}',
        [HorarioController::class, 'eliminarCapturaRapida']
    )->name('horarios.captura-rapida.eliminar');

    Route::resource('horarios', HorarioController::class);

    /*
    |--------------------------------------------------------------------------
    | AULAS
    |--------------------------------------------------------------------------
    */

    Route::resource('aulas', AulaController::class);

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
    | HISTORIAL DEL ALUMNO
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/incidencias/alumno/{alumno}/historial',
        [IncidenciaController::class, 'historial']
    )->name('incidencias.historial');

    /*
    |--------------------------------------------------------------------------
    | CITATORIOS
    |--------------------------------------------------------------------------
    */

    Route::resource('citatorios', CitatorioController::class);

    Route::post(
        '/citatorios/{citatorio}/notificar',
        [CitatorioController::class, 'notificar']
    )->name('citatorios.notificar');

    /*
    |--------------------------------------------------------------------------
    | INCIDENCIAS
    |--------------------------------------------------------------------------
    */

    Route::resource('incidencias', IncidenciaController::class);

    /*
    |--------------------------------------------------------------------------
    | MÓDULO DE TUTORÍAS
    |--------------------------------------------------------------------------
    */

    // ACTIVIDADES GRUPALES
    Route::resource(
        'tutorias/actividades',
        ActividadTutoriaController::class
    )->names('tutorias.actividades');

    // LISTADO DE EXPEDIENTES
    Route::get(
        'tutorias/expedientes',
        [ExpedienteTutoriaController::class, 'index']
    )->name('tutorias.expedientes.index');

    // EXPEDIENTE INDIVIDUAL DEL ALUMNO
    Route::get(
        'tutorias/alumnos/{alumno}/expediente',
        [ExpedienteTutoriaController::class, 'show']
    )->name('tutorias.expedientes.show');

    // REGISTRAR SEGUIMIENTOS
    Route::post(
        'tutorias/{tutoria}/seguimientos',
        [SeguimientoTutoriaController::class, 'store']
    )->name('tutorias.seguimientos.store');

    // ACTUALIZAR SEGUIMIENTOS
    Route::put(
        'tutorias/seguimientos/{seguimiento}',
        [SeguimientoTutoriaController::class, 'update']
    )->name('tutorias.seguimientos.update');

    // ATENCIÓN INDIVIDUAL
    Route::resource('tutorias', TutoriaController::class);
    
    Route::get(
    'prestamos_equipos/buscar-alumnos',
    [PrestamoEquipoController::class, 'buscarAlumnos']
)->name('prestamos_equipos.buscar_alumnos');

Route::get(
    'prestamos_equipos/materias-por-docente/{id}',
    [PrestamoEquipoController::class, 'materiasPorDocente']
)->name('prestamos_equipos.materias_por_docente');
    /*
    |--------------------------------------------------------------------------
    | PRÉSTAMO DE EQUIPO TECNOLÓGICO
    |--------------------------------------------------------------------------
    */
    
    // INVENTARIO DE EQUIPOS TECNOLÓGICOS
Route::resource(
    'equipos_tecnologicos',
    EquipoTecnologicoController::class
)->parameters([
    'equipos_tecnologicos' => 'equipoTecnologico'
]);
    // RESERVACIONES
    Route::prefix('reservaciones-equipos')
        ->name('reservaciones_equipos.')
        ->group(function () {

            // LISTADO
            Route::get(
                '/',
                [ReservacionEquipoController::class, 'index']
            )->name('index');

            // FORMULARIO DE RESERVACIÓN
            Route::get(
                '/crear',
                [ReservacionEquipoController::class, 'create']
            )->name('create');

            // BUSCAR ALUMNOS
            Route::get(
                '/buscar-alumnos',
                [ReservacionEquipoController::class, 'buscarAlumnos']
            )->name('buscar_alumnos');

            // MATERIAS POR SEMESTRE
            Route::get(
                '/materias-por-semestre',
                [ReservacionEquipoController::class, 'materiasPorSemestre']
            )->name('materias_por_semestre');

            // CALENDARIO
            Route::get(
                '/calendario',
                [ReservacionEquipoController::class, 'calendario']
            )->name('calendario');

            // GUARDAR RESERVACIÓN
            Route::post(
                '/',
                [ReservacionEquipoController::class, 'store']
            )->name('store');

            // APROBAR RESERVACIÓN
            Route::patch(
                '/{reservacionEquipo}/aprobar',
                [ReservacionEquipoController::class, 'aprobar']
            )->name('aprobar');

            // RECHAZAR RESERVACIÓN
            Route::patch(
                '/{reservacionEquipo}/rechazar',
                [ReservacionEquipoController::class, 'rechazar']
            )->name('rechazar');

            // CANCELAR RESERVACIÓN
            Route::patch(
                '/{reservacionEquipo}/cancelar',
                [ReservacionEquipoController::class, 'cancelar']
            )->name('cancelar');

            // VER DETALLE
            Route::get(
                '/{reservacionEquipo}',
                [ReservacionEquipoController::class, 'show']
            )->name('show');
        });

    /*
    |--------------------------------------------------------------------------
    | PRÉSTAMOS TRADICIONALES
    |--------------------------------------------------------------------------
    */

Route::resource(
    'prestamos_equipos',
    PrestamoEquipoController::class
)->parameters([
    'prestamos_equipos' => 'prestamoEquipo'
]);

});
require __DIR__.'/auth.php';