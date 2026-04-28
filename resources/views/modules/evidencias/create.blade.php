@extends('layouts.main')

@section('titulo', 'Crear Nueva Evidencia')

@section('contenido')
<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="fw-bold text-primary">Crear Nueva Evidencia</h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="" class="text-decoration-none text-secondary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('evidencias') }}" class="text-decoration-none text-secondary">Evidencias</a>
                </li>
                <li class="breadcrumb-item active text-primary fw-semibold">Nueva</li>
            </ol>
        </nav>
    </div>

    <section class="section">

        <div class="row justify-content-center">
            <div class="col-lg-11">

                <div class="card border-0 shadow-lg evidencia-card">

                    <div class="card-header evidencia-header">

                        <div class="d-flex align-items-center">

                            <div class="icon-box me-3">
                                <i class="bi bi-cloud-arrow-up-fill fs-3 text-white"></i>
                            </div>

                            <div>
                                <h4 class="mb-1 fw-bold text-dark">
                                    Detalles de la Evidencia
                                </h4>

                                <p class="mb-0 text-muted">
                                    Complete todos los campos para registrar los archivos en el sistema.
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="card-body p-4">

                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">

                                <label class="form-label fw-bold text-uppercase text-secondary small">
                                    Revisión
                                </label>

                                <div class="input-group input-custom">

                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-journal-bookmark-fill text-primary"></i>
                                    </span>

                                    <select name="revision_id" class="form-control border-start-0" required>
                                        <option value="" selected disabled>
                                            Seleccione revisión
                                        </option>

                                        @foreach($revisiones as $revision)
                                        <option value="{{ $revision->id }}">
                                            {{ $revision->nombre }}
                                        </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="row g-4">

                                <div class="col-md-6">

                                    <div class="section-box">
                                        <h4 class="section-title">
                                            <i class="bi bi-folder2-open me-2"></i>
                                            Documentos
                                        </h4>

                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">
                                                a) Instrumentación didáctica completa, por asignatura
                                            </label>

                                            <div class="d-flex gap-2 align-items-center">
                                                <input type="file" name="doc_a" class="form-control" accept=".pdf" required>

                                                <button type="button" class="btn btn-danger btn-sm action-btn">
                                                    <i class="fa-solid fa-file-circle-minus"></i>
                                                </button>

                                                <button type="button" class="btn btn-primary btn-sm action-btn">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            </div>

                                            <small class="helper-text">
                                                Solo PDF • Máximo 1 MB
                                            </small>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">
                                                b) Lista de calificaciones
                                            </label>

                                            <div class="d-flex gap-2 align-items-center">
                                                <input type="file" name="doc_b" class="form-control" accept=".pdf" required>

                                                <button type="button" class="btn btn-danger btn-sm action-btn">
                                                    <i class="fa-solid fa-file-circle-minus"></i>
                                                </button>

                                                <button type="button" class="btn btn-primary btn-sm action-btn">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            </div>

                                            <small class="helper-text">
                                                Solo PDF • Máximo 1 MB
                                            </small>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label fw-semibold">
                                                c) Reporte y acuerdos
                                            </label>

                                            <div class="d-flex gap-2 align-items-center">
                                                <input type="file" name="doc_c" class="form-control" accept=".pdf" required>

                                                <button type="button" class="btn btn-danger btn-sm action-btn">
                                                    <i class="fa-solid fa-file-circle-minus"></i>
                                                </button>

                                                <button type="button" class="btn btn-primary btn-sm action-btn">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            </div>

                                            <small class="helper-text">
                                                Solo PDF • Máximo 1 MB
                                            </small>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="section-box">
                                        <h4 class="section-title">
                                            <i class="bi bi-journal-check me-2"></i>
                                            Evidencias
                                        </h4>

                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">
                                                a) Muestra de tareas y/o trabajos complementarios
                                            </label>

                                            <div class="d-flex gap-2 align-items-center">
                                                <input type="file" name="evi_a" class="form-control" accept=".pdf" required>

                                                <button type="button" class="btn btn-danger btn-sm action-btn">
                                                    <i class="fa-solid fa-file-circle-minus"></i>
                                                </button>

                                                <button type="button" class="btn btn-primary btn-sm action-btn">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            </div>

                                            <small class="helper-text">
                                                Solo PDF • Máximo 1 MB
                                            </small>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">
                                                b) Rúbricas utilizadas para tareas y trabajos por asignatura
                                            </label>

                                            <div class="d-flex gap-2 align-items-center">
                                                <input type="file" name="evi_b" class="form-control" accept=".pdf" required>

                                                <button type="button" class="btn btn-danger btn-sm action-btn">
                                                    <i class="fa-solid fa-file-circle-minus"></i>
                                                </button>

                                                <button type="button" class="btn btn-primary btn-sm action-btn">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            </div>

                                            <small class="helper-text">
                                                Solo PDF • Máximo 1 MB
                                            </small>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label fw-semibold">
                                                c) Examen diagnóstico y análisis de este
                                            </label>

                                            <div class="d-flex gap-2 align-items-center">
                                                <input type="file" name="evi_c" class="form-control" accept=".pdf" required>

                                                <button type="button" class="btn btn-danger btn-sm action-btn">
                                                    <i class="fa-solid fa-file-circle-minus"></i>
                                                </button>

                                                <button type="button" class="btn btn-primary btn-sm action-btn">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            </div>

                                            <small class="helper-text">
                                                Solo PDF • Máximo 1 MB
                                            </small>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-success px-5 py-2 fw-semibold submit-btn">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    Subir Evidencia
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </section>

</main>


<style>
    .evidencia-card {
        border-radius: 18px;
        overflow: hidden;
        background: #ffffff;
    }

    .evidencia-header {
        background: linear-gradient(135deg, #f8fbff, #eef5ff);
        border-bottom: 1px solid #e8eef7;
        padding: 25px;
    }

    .icon-box {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        background: linear-gradient(135deg, #0d6efd, #4da3ff);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.18);
    }

    .section-box {
        background: #fafcff;
        border: 1px solid #e9f0fa;
        border-radius: 16px;
        padding: 25px;
        height: 100%;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #0d6efd;
        margin-bottom: 25px;
    }

    .helper-text {
        color: #6c757d;
        font-size: 13px;
    }

    .form-control,
    .input-group-text,
    select {
        border-radius: 10px !important;
        min-height: 45px;
    }

    .form-control:focus,
    select:focus {
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.15);
        border-color: #86b7fe;
    }

    .action-btn {
        width: 42px;
        height: 42px;
        border-radius: 10px;
    }

    .submit-btn {
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(25, 135, 84, 0.18);
        transition: 0.3s;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
    }
</style>

@endsection