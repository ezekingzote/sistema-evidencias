@extends('layouts.main')

@section('titulo', 'Crear Nueva Evidencia')

@section('contenido')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Crear Nueva Evidencia</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('mis-evidencias') }}">Evidencias</a></li>
                    <li class="breadcrumb-item active">Nueva</li>
                </ol>
            </nav>
        </div><section class="section">
            <div class="row justify-content-center">
                <div class="col-lg-11">

                    <div class="card shadow-sm border-0" style="border-radius: 15px;">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-primary bg-opacity-10 rounded-3 me-3">
                                    <i class="bi bi-cloud-arrow-up-fill text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-0 p-0">Detalles de la Evidencia</h5>
                                    <small class="text-muted">Complete los campos para registrar el archivo en el sistema.</small>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <form id="formNuevaEvidencia" action="#" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-4">

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Materia</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-book text-muted"></i></span>
                                            <select class="form-select border-start-0 bg-light" required>
                                                <option selected disabled>Elegir materia...</option>
                                                <option>Backend</option>
                                                <option>IA</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Unidad Académica</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-bookmark text-muted"></i></span>
                                            <select class="form-select border-start-0 bg-light" required>
                                                <option>Unidad 1</option>
                                                <option>Unidad 2</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold">Tipo de Evidencia</label>
                                        <select class="form-select" style="border-left: 5px solid #0d6efd;" required>
                                            <option selected disabled>Seleccione el tipo de documento...</option>
                                            <optgroup label="DOCUMENTOS">
                                                <option value="instrumentacion">Instrumentación didáctica completa</option>
                                                <option value="calificaciones">Listas de calificaciones</option>
                                                <option value="reportes">Reportes y Acuerdos</option>
                                            </optgroup>
                                            <optgroup label="EVIDENCIAS">
                                                <option value="tareas">Muestra de tareas y/o trabajos complementarios</option>
                                                <option value="rubricas">Rúbricas utilizadas para tareas y trabajos</option>
                                                <option value="examen">Examen diagnóstico y análisis de este</option>
                                            </optgroup>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Archivo de Evidencia (PDF)</label>
                                        <input type="file" class="form-control bg-light" accept=".pdf" required>
                                        <div class="form-text small"><i class="bi bi-info-circle me-1"></i> Solo formato .pdf</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Archivo de Rúbrica (PDF)</label>
                                        <input type="file" class="form-control bg-light" accept=".pdf" required>
                                        <div class="form-text small"><i class="bi bi-info-circle me-1"></i> Solo formato .pdf</div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold" for="selectRubrica">Plan de estudio correspondiente</label>
                                        <select class="form-select bg-light" id="selectRubrica">
                                            <option selected disabled>Elegir plan correspondiente...</option>
                                            <option>Examen escrito --- 50%</option>
                                            <option>Trabajo en Clase --- 30% </option>
                                        </select>
                                    </div>

                                    <div class="col-12 mt-4 border-top pt-4 d-flex justify-content-end gap-3">
                                        <button type="reset" class="btn btn-light px-4">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Limpiar
                                        </button>
                                        <a href="{{ route('mis-evidencias') }}" class="btn btn-outline-secondary px-4">
                                            Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                            <i class="bi bi-cloud-upload me-1"></i> Subir Evidencia
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection