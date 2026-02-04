<?php

use App\Http\Controllers\AsignarMaterias;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Docentes;
use App\Http\Controllers\Evidencias;
use App\Http\Controllers\Materias;
use App\Http\Controllers\PlanesEstudio;
use App\Http\Controllers\Semestres;
use Illuminate\Support\Facades\Route;

// Rutas Públicas e Iniciales
Route::get('/crear-admin', [AuthController::class, 'crearAdmin']);
Route::get('/crear-docente', [AuthController::class, 'crearUsuario']);
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/logear', [AuthController::class, 'logear'])->name('logear');

// Rutas Protegidas por Autenticación
Route::middleware('auth')->group(function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // ==========================================
    // RUTAS ADMIN
    // ==========================================
    Route::middleware('Checkrol:admin')->group(function () {
        Route::get('/home', [Dashboard::class, 'index'])->name('home');

        Route::prefix('evidencias')->group(function () {
            Route::get('/', [Evidencias::class, 'index'])->name('evidencias');
            Route::get('/review', [Evidencias::class, 'review'])->name('review-evidencia');
        });

        Route::prefix('semestres')->group(function () {
            Route::get('/', [Semestres::class, 'index'])->name('semestres');
        });

        Route::prefix('docentes')->group(function () {
            Route::get('/', [Docentes::class, 'index'])->name('docentes');
            Route::get('/create', [Docentes::class, 'create'])->name('nuevo-docente');
        });

        Route::prefix('asignar-materias')->group(function () {
            Route::get('/', [AsignarMaterias::class, 'index'])->name('asignar-materias');
            Route::get('/agregar', [AsignarMaterias::class, 'agregar'])->name('agregar-materia');
        });


        Route::prefix('materias')->group(function () {
            Route::get('/', [Materias::class, 'index'])->name('materias');
            Route::get('/create', [Materias::class, 'create'])->name('nueva-materia');
            Route::post('/store', [Materias::class, 'store'])->name('materias.store');
            Route::get('/edit/{id}', [Materias::class, 'edit'])->name('materias.edit');
            Route::put('/update/{id}', [Materias::class, 'update'])->name('materias.update');
            Route::get('/tbody', [Materias::class, 'tbody'])->name('materias.tbody');
            Route::get('/cambiar-estado/{id}/{estado}', [Materias::class, 'estado'])->name('materias.estado');
            Route::get('/show/{id}', [Materias::class, 'show'])->name('materias.show');
            Route::delete('/destroy/{id}', [Materias::class, 'destroy'])->name('materias.destroy');
        });
    });

    // ==========================================
    // RUTAS DOCENTE
    // ==========================================
    Route::middleware('Checkrol:docente')->group(function () {
        // Dashboard específico del docente
        Route::get('/dashboard', [Dashboard::class, 'indexDocente'])->name('dashboard');

        Route::prefix('mis-evidencias')->group(function () {
            Route::get('/', [Evidencias::class, 'indexDocente'])->name('mis-evidencias');
            Route::get('/agregar', [Evidencias::class, 'agregarEvidencia'])->name('agregar-evidencia');
        });

        Route::prefix('mis-materias')->group(function () {
            Route::get('/', [Materias::class, 'misMaterias'])->name('mis-materias');
        });

        Route::prefix('planes-estudio')->group(function () {
            Route::get('/', [PlanesEstudio::class, 'index'])->name('planes-estudio');
            Route::get('/agregar', [PlanesEstudio::class, 'agregar'])->name('agregar-plan-estudio');
        });
    });
});
