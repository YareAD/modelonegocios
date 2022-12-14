<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\ArtefactosController;
use App\Http\Controllers\CasosUsoController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ProcesosController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\RequerimientosController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// return Inertia::render('Welcome', [
//     'canLogin' => Route::has('login'),
//     'canRegister' => Route::has('register'),
//     'laravelVersion' => Application::VERSION,
//     'phpVersion' => PHP_VERSION,
// ]);

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/proyectos');
    }
    return redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    /* Proyectos */
    Route::get('/proyectos', [ProyectoController::class, 'index'])->name('inicio');
    Route::get('/nuevo-proyecto', [ProyectoController::class, 'create'])->name('nuevo-proyecto');
    Route::post('/registrar-proyecto', [ProyectoController::class, 'store'])->name('registrar-proyecto');
    Route::get('/proyecto/{proyecto}', [ProyectoController::class, 'show'])->name('visualizar-proyecto');
    Route::delete('/proyecto/{proyecto}', [ProyectoController::class, 'destroy'])->name('eliminar-proyecto');
    Route::get('/editar/proyecto/{proyecto}', [ProyectoController::class, 'showEdit'])->name('editar-proyecto');
    Route::post('/proyecto/{proyecto}', [ProyectoController::class, 'update'])->name('editar-proyecto-post');
    Route::get('/reporte/proyecto/{proyecto}', [ProyectoController::class, 'reporte'])->name('reporte-proyecto');


    Route::get('/actores/proyecto/{proyecto}', [ActorController::class, 'index'])->name('actores');
    Route::get('/nuevo-actor/proyecto/{proyecto}', [ActorController::class, 'create'])->name('nuevo-actor');
    Route::post('/nuevo-actor', [ActorController::class, 'store'])->name('nuevo-actor-post');
    Route::delete('/actor/{actor}', [ActorController::class, 'destroy'])->name('eliminar-actor');
    Route::get('/actor/{actor}', [ActorController::class, 'show'])->name('visualizar-actor');
    Route::post('/editar-actor', [ActorController::class, 'update'])->name('editar-actor');


    Route::get('/artefactos/proyecto/{proyecto}', [ArtefactosController::class, 'index'])->name('artefactos');
    Route::delete('/artefacto/{artefacto}', [ArtefactosController::class, 'destroy'])->name('eliminar-artefacto');
    Route::get('/nuevo-artefacto/proyecto/{proyecto}', [ArtefactosController::class, 'create'])->name('nuevo-artefacto');
    Route::post('/nuevo-artefacto', [ArtefactosController::class, 'store'])->name('nuevo-artefacto-post');
    Route::get('/artefacto/{artefacto}', [ArtefactosController::class, 'show'])->name('visualizar-artefacto');
    Route::post('/editar-artefacto', [ArtefactosController::class, 'update'])->name('editar-artefacto');

    Route::delete('/dato/artefacto/{dato}', [ArtefactosController::class, 'destroyDato'])->name('eliminar-dato');
    Route::post('/dato/artefacto', [ArtefactosController::class, 'storeDato'])->name('agregar-dato');
    Route::post('/dato/editar', [ArtefactosController::class, 'updateDato'])->name('editar-dato');


    Route::get('/procesos/proyecto/{proyecto}', [ProcesosController::class, 'index'])->name('procesos');
    Route::get('/nuevo-proceso/proyecto/{proyecto}', [ProcesosController::class, 'create'])->name('nuevo-proceso');
    Route::post('/nuevo-proceso', [ProcesosController::class, 'store'])->name('nuevo-proceso-post');
    Route::delete('/proceso/{proceso}', [ProcesosController::class, 'destroy'])->name('eliminar-proceso');
    Route::get('/proceso/{proceso}', [ProcesosController::class, 'show'])->name('visualizar-proceso');
    Route::post('/proceso/editar', [ProcesosController::class, 'update'])->name('editar-proceso-post');

    Route::get('/requerimientos/proyecto/{proyecto}', [RequerimientosController::class, 'index'])->name('requerimientos');
    Route::get('/nuevo-requerimiento/proyecto/{proyecto}', [RequerimientosController::class, 'create'])->name('nuevo-requerimiento');
    Route::post('/nuevo-requerimiento', [RequerimientosController::class, 'store'])->name('nuevo-requerimiento-post');
    Route::get('/editar-requerimiento/{requerimiento}', [RequerimientosController::class, 'edit'])->name('edit-requerimiento');
    Route::post('/update-requerimiento/{requerimiento}', [RequerimientosController::class, 'update'])->name('update-requerimiento');
    Route::delete('/eliminar-requerimiento/{requerimiento}', [RequerimientosController::class, 'destroy'])->name('eliminar-requerimiento');



    Route::get('/casos-uso/proyecto/{proyecto}', [CasosUsoController::class, 'index'])->name('casos-uso');
    Route::get('/nuevo-caso-uso/proyecto/{proyecto}', [CasosUsoController::class, 'create'])->name('nuevo-caso-uso');
    Route::post('/nuevo-caso-uso', [CasosUsoController::class, 'store'])->name('nuevo-caso-uso-post');
    Route::get('/editar-caso-uso/{casoUso}', [CasosUsoController::class, 'edit'])->name('edit-caso-uso');
    Route::post('/update-caso-uso/caso-uso/{casoUso}', [CasosUsoController::class, 'update'])->name('update-caso-uso-post');
    Route::delete('/eliminar-caso-uso/{casoUso}', [CasosUsoController::class, 'destroy'])->name('eliminar-caso-uso');
});


require __DIR__ . '/auth.php';
