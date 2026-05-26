@extends('layouts.main')

@section('titulo', 'Crear Nueva Evidencia')

@section('contenido')

<main id="main" class="main">

    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-primary">Crear Nueva Evidencia</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('evidencias') }}" class="text-decoration-none">Evidencias</a></li>
                <li class="breadcrumb-item active fw-semibold">Nueva</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                {{-- PANEL DEL FORMULARIO --}}
                <div class="card border-0 shadow-lg p-4" style="border-radius: 20px; background: white;">
                    <div class="mb-4">
                        <h5 class="fw-bold text-secondary mb-1">Carga de archivos</h5>
                        <p class="text-muted small">Asegúrese de que todos los documentos sean en formato PDF y cumplan con los lineamientos.</p>
                    </div>



                    <form action="{{ route('evidencias.store') }}" method="POST" enctype="multipart/form-data">
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


                        {{-- DOCUMENTOS --}}
                        <div class="mb-4">
                            <h4 class="fw-bold text-primary border-bottom pb-2"><i class="bi bi-folder-fill me-2"></i> Documentos</h4>
                        </div>

                        <div class="row g-4 mb-5">
                            @foreach(['doc_a' => 'a) Instrumentación didáctica completa', 'doc_b' => 'b) Lista de calificaciones', 'doc_c' => 'c) Reporte y acuerdos'] as $campo => $label)
                            <div class="col-md-4">
                                <div class="p-3 border rounded-3 bg-light-subtle h-100 row-file-card">
                                    <label class="form-label fw-bold text-dark small text-uppercase mb-2 d-block">{{ $label }}</label>
                                    <input type="file" class="form-control form-control-sm" name="{{ $campo }}" accept="application/pdf" required>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- EVIDENCIAS --}}
                        <div class="mb-4">
                            <h4 class="fw-bold text-success border-bottom pb-2"><i class="bi bi-journal-check me-2"></i> Evidencias</h4>
                        </div>

                        <div class="row g-4">
                            @foreach(['evi_a' => 'a) Muestra de tareas y trabajos complementarios', 'evi_b' => 'b) Rúbricas utilizadas para tareas y trabajos', 'evi_c' => 'c) Examen diagnóstico y análisis'] as $campo => $label)
                            <div class="col-md-4">
                                <div class="p-3 border rounded-3 bg-light-subtle h-100 row-file-card">
                                    <label class="form-label fw-bold text-dark small text-uppercase mb-2 d-block">{{ $label }}</label>
                                    <input type="file" class="form-control form-control-sm" name="{{ $campo }}" accept="application/pdf" required>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <hr class="my-4 style-hr">

                        <div class="d-flex gap-2">
                            <a href="{{ route('evidencias') }}" class="btn btn-light px-4 py-2 rounded-pill border fw-semibold small"><i class="bi bi-arrow-left-short fs-5 align-middle"></i>Regresar</a>
                            <button type="submit" class="btn btn-outline-primary px-4 py-2 rounded-pill shadow-sm fw-semibold small">
                                <i class="bi bi-cloud-upload me-1"></i> Subir Evidencia
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    const combinacionesSubidas = JSON.parse('{!! json_encode($subidasArray) !!}');
    const revisionesOriginales = JSON.parse('{!! json_encode($revisiones) !!}');

    document.getElementById('materia_id').addEventListener('change', function() {
        const materiaId = this.value;
        const selectRevision = document.getElementById('revision_id');
        selectRevision.innerHTML = '<option value="" selected disabled>Seleccione una revisión</option>';

        let disponibles = 0;
        revisionesOriginales.forEach(revision => {
            if (!combinacionesSubidas.includes(`${materiaId}-${revision.id}`)) {
                const option = document.createElement('option');
                option.value = revision.id;
                option.text = revision.nombre;
                selectRevision.appendChild(option);
                disponibles++;
            }
        });

        selectRevision.disabled = (disponibles === 0);
        if (disponibles === 0) selectRevision.innerHTML = '<option>No hay revisiones disponibles</option>';
    });
</script>

<style>
    .row-file-card {
        border: 1px solid #e2e8f0;
        transition: transform .2s ease;
    }

    .row-file-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }

    .style-hr {
        opacity: 0.1;
    }

    .form-select {
        background-color: #fff !important;
        color: #000 !important;
    }

    .form-select option {
        background-color: #fff !important;
        color: #000 !important;
    }
</style>

@endsection