@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Crear Nueva evidencia</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./evidencias-docente-index.php">Home</a></li>
                    <li class="breadcrumb-item active">Crear una evidencia Nueva</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4 pt-3">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                                    <i class="bi bi-cloud-arrow-up-fill text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-0 pb-0">Detalles de la Evidencia</h5>
                                    <p class="text-muted small mb-0">Complete todos los campos para registrar el archivo en
                                        el sistema.</p>
                                </div>
                            </div>

                            <form id="formNuevaEvidencia" class="row g-4">
                                <div class="col-md-6">
                                    <label
                                        class="form-label fw-semibold text-secondary small text-uppercase">Materia</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i
                                                class="bi bi-book text-muted"></i></span>
                                        <select class="form-select border-start-0 ps-0" required>
                                            <option selected disabled>Elegir materia...</option>
                                            <option>Backend</option>
                                            <option>IA</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary small text-uppercase">Unidad
                                        Académica</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i
                                                class="bi bi-bookmark text-muted"></i></span>
                                        <select class="form-select border-start-0 ps-0" required>
                                            <option>Unidad 1</option>
                                            <option>Unidad 2</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold text-secondary small text-uppercase">Tipo de
                                        Evidencia</label>
                                    <select class="form-select" required>
                                        <optgroup label="Alumnos">
                                            <option>Tareas</option>
                                            <option>Prácticas</option>
                                        </optgroup>
                                        <optgroup label="Docente">
                                            <option>Examen resuelto</option>
                                            <option>Calificación unidad</option>
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="col-6">
                                    <label class="form-label fw-semibold text-secondary small text-uppercase">Archivo de
                                        Evidencia (PDF)</label>
                                    <input type="file" class="form-control" accept=".pdf" required>
                                    <div class="form-text mt-2"><i class="bi bi-info-circle me-1"></i> Solo se permiten
                                        archivos con extensión .pdf</div>
                                </div>

                                <div class="col-6">
                                    <label class="form-label fw-semibold text-secondary small text-uppercase">Archivo de
                                        Rúbrica (PDF)</label>
                                    <input type="file" class="form-control" accept=".pdf" required>
                                    <div class="form-text mt-2"><i class="bi bi-info-circle me-1"></i> Solo se permiten
                                        archivos con extensión .pdf</div>
                                </div>

                                <div class="col-12" id="contenedorRubrica">Plan de estudio</label>
                                    <select class="form-select" id="selectRubrica">
                                        <option selected disabled>Elegir plan correspondiente...</option>
                                        <option>Exámen escrito --- 50%</option>
                                        <option>Trabajo en Clase --- 30% </option>
                                    </select>
                                </div>

                                <div class="col-12 mt-5">
                                    <div class="d-flex justify-content-between gap-2">
                                        <a href="{{ route('mis-evidencias') }}" class="btn btn-outline-info"><i
                                                class="fa-solid fa-arrow-left-long"></i> Regresar</a>
                                        <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                            <i class="bi bi-cloud-upload me-1"></i> Subir Evidencia
                                        </button>
                                        <button type="reset" class="btn btn-light px-4">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Limpiar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </main><!-- End #main -->
@endsection
