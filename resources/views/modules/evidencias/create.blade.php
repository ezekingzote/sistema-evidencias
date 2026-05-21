@extends('layouts.main')

@section('titulo', 'Crear Nueva Evidencia')

@section('contenido')

<main id="main" class="main">

    <div class="pagetitle">

        <h1 class="fw-bold text-primary">
            Crear Nueva Evidencia
        </h1>

        <nav>

            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="" class="text-decoration-none text-secondary">
                        Home
                    </a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('evidencias') }}"
                        class="text-decoration-none text-secondary">

                        Evidencias

                    </a>
                </li>

                <li class="breadcrumb-item active text-primary fw-semibold">
                    Nueva
                </li>

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

                        <form action="{{ route('evidencias.store') }}"
                            method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="row g-4 mb-4">

                                {{-- MATERIA --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-bold text-uppercase text-secondary small">

                                        Materia Académica

                                    </label>

                                    <div class="input-group input-custom shadow-sm">

                                        <span class="input-group-text bg-white border-end-0">

                                            <i class="bi bi-book-half text-primary"></i>

                                        </span>

                                        <select name="materia_id"
                                            id="materia_id"
                                            class="form-control border-start-0"
                                            required>

                                            <option value="" selected disabled>
                                                Seleccione materia
                                            </option>

                                            @foreach ($materias as $materia)

                                            <option value="{{ $materia->id }}">

                                                {{ $materia->nombre }}

                                            </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                                {{-- REVISION --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-bold text-uppercase text-secondary small">

                                        Revisión

                                    </label>

                                    <div class="input-group input-custom shadow-sm">

                                        <span class="input-group-text bg-white border-end-0">

                                            <i class="bi bi-journal-bookmark-fill text-primary"></i>

                                        </span>

                                        <select name="revision_id"
                                            id="revision_id"
                                            class="form-control border-start-0"
                                            required
                                            disabled>

                                            <option value="" selected disabled>
                                                Seleccione primero una materia
                                            </option>

                                            @foreach ($revisiones as $revision)

                                            <option value="{{ $revision->id }}">

                                                {{ $revision->nombre }}

                                            </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                            </div>

                            <div class="row g-4">

                                {{-- DOCUMENTOS --}}
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

                                            <input type="file"
                                                name="doc_a"
                                                class="form-control"
                                                accept=".pdf"
                                                required>

                                            <small class="helper-text">
                                                Solo PDF • Máximo 1 MB
                                            </small>

                                        </div>

                                        <div class="mb-4">

                                            <label class="form-label fw-semibold">

                                                b) Lista de calificaciones

                                            </label>

                                            <input type="file"
                                                name="doc_b"
                                                class="form-control"
                                                accept=".pdf"
                                                required>

                                            <small class="helper-text">
                                                Solo PDF • Máximo 1 MB
                                            </small>

                                        </div>

                                        <div class="mb-2">

                                            <label class="form-label fw-semibold">

                                                c) Reporte y acuerdos

                                            </label>

                                            <input type="file"
                                                name="doc_c"
                                                class="form-control"
                                                accept=".pdf"
                                                required>

                                            <small class="helper-text">
                                                Solo PDF • Máximo 1 MB
                                            </small>

                                        </div>

                                    </div>

                                </div>

                                {{-- EVIDENCIAS --}}
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

                                            <input type="file"
                                                name="evi_a"
                                                class="form-control"
                                                accept=".pdf"
                                                required>

                                            <small class="helper-text">
                                                Solo PDF • Máximo 1 MB
                                            </small>

                                        </div>

                                        <div class="mb-4">

                                            <label class="form-label fw-semibold">

                                                b) Rúbricas utilizadas para tareas y trabajos por asignatura

                                            </label>

                                            <input type="file"
                                                name="evi_b"
                                                class="form-control"
                                                accept=".pdf"
                                                required>

                                            <small class="helper-text">
                                                Solo PDF • Máximo 1 MB
                                            </small>

                                        </div>

                                        <div class="mb-2">

                                            <label class="form-label fw-semibold">

                                                c) Examen diagnóstico y análisis de este

                                            </label>

                                            <input type="file"
                                                name="evi_c"
                                                class="form-control"
                                                accept=".pdf"
                                                required>

                                            <small class="helper-text">
                                                Solo PDF • Máximo 1 MB
                                            </small>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="text-center mt-5">

                                <button type="submit"
                                    class="btn btn-success px-5 py-2 fw-semibold submit-btn">

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

<script>
    const combinacionesSubidas =
        JSON.parse('{!! json_encode($subidasArray) !!}');

    const revisionesOriginales =
    JSON.parse('{!! json_encode($revisiones) !!}');

    document
        .getElementById('materia_id')
        .addEventListener('change', function() {

            const materiaId = this.value;

            const selectRevision =
                document.getElementById('revision_id');

            selectRevision.innerHTML = '';

            if (!materiaId) {

                selectRevision.disabled = true;

                const opcion =
                    document.createElement('option');

                opcion.text =
                    'Seleccione primero una materia';

                opcion.selected = true;

                selectRevision.appendChild(opcion);

                return;
            }

            let disponibles = 0;

            revisionesOriginales.forEach(revision => {

                const llaveCombinacion =
                    `${materiaId}-${revision.id}`;

                if (
                    !combinacionesSubidas.includes(
                        llaveCombinacion
                    )
                ) {

                    const option =
                        document.createElement('option');

                    option.value = revision.id;

                    option.text = revision.nombre;

                    selectRevision.appendChild(option);

                    disponibles++;
                }

            });

            if (disponibles === 0) {

                const opcion =
                    document.createElement('option');

                opcion.text =
                    'No hay revisiones disponibles';

                opcion.selected = true;

                selectRevision.appendChild(opcion);

                selectRevision.disabled = true;

            } else {

                selectRevision.disabled = false;

            }

        });
</script>

<style>
    .evidencia-card {

        border-radius: 18px;
        overflow: hidden;
        background: #ffffff;

    }

    .evidencia-header {

        background: linear-gradient(135deg,
                #f8fbff,
                #eef5ff);

        border-bottom: 1px solid #e8eef7;

        padding: 25px;

    }

    .icon-box {

        width: 60px;
        height: 60px;
        border-radius: 16px;

        background: linear-gradient(135deg,
                #0d6efd,
                #4da3ff);

        display: flex;
        align-items: center;
        justify-content: center;

        box-shadow:
            0 8px 20px rgba(13, 110, 253, 0.18);

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

        box-shadow:
            0 0 0 0.15rem rgba(13, 110, 253, 0.15);

        border-color: #86b7fe;

    }

    .submit-btn {

        border-radius: 12px;

        box-shadow:
            0 8px 20px rgba(25, 135, 84, 0.18);

        transition: 0.3s;

    }

    .submit-btn:hover {

        transform: translateY(-2px);

    }
</style>

@endsection