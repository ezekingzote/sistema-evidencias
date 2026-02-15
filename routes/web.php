<?php

use App\Http\Controllers\AsignarMaterias;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Docentes;
use App\Http\Controllers\Evidencias;
use App\Http\Controllers\Materias;
use App\Http\Controllers\Pdfs;
use App\Http\Controllers\PlanesEstudio;
use App\Http\Controllers\Semestres;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Rutas Públicas e Iniciales
Route::get('/crear-admin', [AuthController::class, 'crearAdmin']);
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/logear', [AuthController::class, 'logear'])->name('logear');

// Rutas Protegidas por Autenticación
Route::middleware('auth')->group(function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::put('/update-password', [AuthController::class, 'updatePassword'])->name('password.update');

    // ==========================================
    // RUTAS ADMIN
    // ==========================================
    Route::middleware('Checkrol:admin')->group(function () {
        Route::get('/home', [Dashboard::class, 'index'])->name('home');


        Route::prefix('semestres')->group(function () {
            Route::get('/', [Semestres::class, 'index'])->name('semestres');
            Route::get('/create', [Semestres::class, 'create'])->name('semestre.create');
            Route::post('/store', [Semestres::class, 'store'])->name('semestre.store');
            Route::get('/verificar', [Semestres::class, 'verificar'])->name('semestre.verificar');
            Route::get('/cards', [Semestres::class, 'cards'])->name('semestres.cards');
            Route::post('/cambiar-estado/{id}', [Semestres::class, 'cambiarEstado']);
            Route::post('/cambiar-estado-confirmar/{id}', [Semestres::class, 'cambiarEstadoConfirmar']);
            Route::get('/edit/{id}', [Semestres::class, 'edit'])->name('semestres.edit');
            Route::put('/update/{id}', [Semestres::class, 'update'])->name('semestres.update');
            Route::get('/show/{id}', [Semestres::class, 'show'])->name('semestres.show');
            Route::delete('/destroy/{id}', [Semestres::class, 'destroy'])->name('semestres.destroy');
        });


        Route::prefix('docentes')->group(function () {
            Route::get('/', [Docentes::class, 'index'])->name('docentes');
            Route::get('/create', [Docentes::class, 'create'])->name('nuevo-docente');
            Route::get('/descargar-comprobante', [Docentes::class, 'downloadPdf'])->name('pdf.descargar');
            Route::post('/store', [Docentes::class, 'store'])->name('docente.store');
            Route::post('/reset-password/{id}', [Docentes::class, 'resetPassword'])->name('docentes.resetPassword');
            Route::get('/tbody', [Docentes::class, 'tbody'])->name('docentes.tbody');
            Route::get('/cambiar-estado/{id}/{estado}', [Docentes::class, 'estado'])->name('docentes.estado');
            Route::get('/edit/{id}', [Docentes::class, 'edit'])->name('docentes.edit');
            Route::put('/update/{id}', [Docentes::class, 'update'])->name('docentes.update');
        });

        Route::prefix('asignar-materias')->group(function () {
            Route::get('/', [AsignarMaterias::class, 'index'])->name('asignar-materias');
            Route::get('/tbody', [AsignarMaterias::class, 'tbody'])->name('asignar-materias.tbody');
            Route::get('/create', [AsignarMaterias::class, 'create'])->name('asignar-materias.create');
            Route::post('/store', [AsignarMaterias::class, 'store'])->name('asignar-materias.store');
            Route::get('/edit/{id}', [AsignarMaterias::class, 'edit'])->name('asignar-materias.edit');
            Route::put('/update/{id}', [AsignarMaterias::class, 'update'])->name('asignar-materias.update');
            Route::get('/show/{id}', [AsignarMaterias::class, 'show'])->name('asignar-materias.show');
            Route::delete('/destroy/{id}', [AsignarMaterias::class, 'destroy'])->name('asignar-materias.destroy');
            Route::post('/estado', [AsignarMaterias::class, 'estado'])->name('asignar-materias.estado');
        });




        Route::prefix('materias')->group(function () {
            Route::get('/', [Materias::class, 'index'])->name('materias');
            Route::get('/create', [Materias::class, 'create'])->name('nueva-materia');
            Route::post('/store', [Materias::class, 'store'])->name('materias.store');
            Route::get('/edit/{id}', [Materias::class, 'edit'])->name('materias.edit');
            Route::put('/update/{id}', [Materias::class, 'update'])->name('materias.update');
            Route::get('/tbody', [Materias::class, 'tbody'])->name('materias.tbody');
            Route::get('/show/{id}', [Materias::class, 'show'])->name('materias.show');
            Route::delete('/destroy/{id}', [Materias::class, 'destroy'])->name('materias.destroy');
            Route::post('/estado', [Materias::class, 'estado'])->name('materias.estado.ajax');
        });
    });

    // ==========================================
    // RUTAS DOCENTE
    // ==========================================
    Route::middleware('Checkrol:docente')->group(function () {
        // Dashboard específico del docente
        Route::get('/dashboard', [Dashboard::class, 'indexDocente'])->name('dashboard');


        Route::prefix('mis-materias')->group(function () {
            Route::get('/', [Materias::class, 'misMaterias'])->name('mis-materias');
        });

        Route::prefix('planes-estudio')->group(function () {
            Route::get('/', [PlanesEstudio::class, 'index'])->name('planes-estudio');
            Route::get('/agregar', [PlanesEstudio::class, 'agregar'])->name('agregar-plan-estudio');
        });
    });
});
