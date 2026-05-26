<?php

use App\Http\Controllers\Archivos;
use App\Http\Controllers\AsignarMaterias;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Docentes;
use App\Http\Controllers\Evaluaciones;
use App\Http\Controllers\Evidencias;
use App\Http\Controllers\Materias;
use App\Http\Controllers\Pdfs;
use App\Http\Controllers\PlanesEstudio;
use App\Http\Controllers\SeguimientoDocentes;
use App\Http\Controllers\Revisiones;
use App\Http\Controllers\SeguimientoAcademico;
use App\Http\Controllers\Semestres;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Rutas Públicas e Iniciales
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/logear', [AuthController::class, 'logear'])->name('logear');

// Rutas Protegidas por Autenticación General
Route::middleware('auth')->group(function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::put('/update-password', [AuthController::class, 'updatePassword'])->name('password.update');

    // ==========================================
    // RUTAS COMPARTIDAS (ADMIN Y DOCENTE)
    // ==========================================
    // Al dejarlas aquí, cualquier usuario logueado (Admin o Docente) podrá ver y descargar archivos
    Route::prefix('archivos')->group(function () {
        Route::get('/', [Archivos::class, 'index'])->name('archivos');
        Route::get('/carpetas/download-zip', [Archivos::class, 'descargarCarpetaZip'])->name('carpetas.zip');
        Route::get('/ver-archivo', [Archivos::class, 'verArchivo'])->name('archivos.ver');
        Route::get('/descargar-archivo', [Archivos::class, 'descargarArchivo'])->name('archivos.descargar');
    });

    // ==========================================
    // RUTAS ADMIN EXCLUSIVAS
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
            Route::get('docentes/data', [Docentes::class, 'data'])->name('docentes.data');
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

        Route::prefix('revisiones')->group(function () {
            Route::get('/', [Revisiones::class, 'index'])->name('revisiones');
            Route::post('/cambiar-estado/{id}', [Revisiones::class, 'cambiarEstado']);
            Route::post('/cambiar-estado-confirmar/{id}', [Revisiones::class, 'cambiarEstadoConfirmar']);
        });

        Route::prefix('seguimiento-academico')->group(function () {
            Route::get('/', [SeguimientoAcademico::class, 'index'])->name('seguimiento-academico');
        });

        Route::prefix('evaluar')->group(function () {
            Route::get('/{id}', [Evaluaciones::class, 'evaluar'])->name('evaluar-evidencias');
            Route::put('/evaluar/{id}/guardar', [Evaluaciones::class, 'guardarEvaluacion'])->name('evidencias-guardar-evaluacion');
        });
    });

    // ==========================================
    // RUTAS DOCENTE EXCLUSIVAS
    // ==========================================
    Route::middleware('Checkrol:docente')->group(function () {
        Route::get('/dashboard', [Dashboard::class, 'indexDocente'])->name('dashboard');

        Route::prefix('mis-materias')->group(function () {
            Route::get('/', [Materias::class, 'misMaterias'])->name('mis-materias');
        });

        Route::prefix('planes-estudio')->group(function () {
            Route::get('/', [PlanesEstudio::class, 'index'])->name('planes-estudio');
            Route::get('/agregar/{materia_id}/{unidad}', [PlanesEstudio::class, 'agregar'])->name('agregar-plan-estudio');
            Route::post('/guardar', [PlanesEstudio::class, 'store'])->name('planes-estudio.store');
            Route::get('/ver/{materia_id}/{unidad}', [PlanesEstudio::class, 'show'])->name('ver-plan-estudio');
            Route::get('/editar/{materia_id}/{unidad}', [PlanesEstudio::class, 'edit'])->name('editar-plan-estudio');
            Route::put('/actualizar', [PlanesEstudio::class, 'update'])->name('planes-estudio.update');
        });

        Route::prefix('evidencias')->group(function () {
            Route::get('/', [Evidencias::class, 'index'])->name('evidencias');
            Route::get('/create', [Evidencias::class, 'create'])->name('evidencias.create');
            Route::post('/guardar', [Evidencias::class, 'store'])->name('evidencias.store');
            Route::get('/ver-detalle/{materia_id}', [Evidencias::class, 'show'])->name('evidencias.show');
            Route::get('/edit/{id}', [Evidencias::class, 'edit'])->name('evidencias.edit');
            Route::put('/update/{id}', [Evidencias::class, 'update'])->name('evidencias.update');
            Route::get('/cambiar-revision/{revisionId}', [Evidencias::class, 'cambiarRevision'])->name('evidencias.cambiarRevision');
        });

        Route::get('/notificaciones/marcar-leidas', function () {
            auth()->user()->unreadNotifications->markAsRead();
            return back();
        })->name('marcar-leidas');
    });
});
