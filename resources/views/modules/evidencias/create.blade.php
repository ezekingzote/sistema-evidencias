@extends('layouts.main')

@section('titulo', 'Crear Evidencia')

@section('contenido')

<main id="main" class="main">

    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-primary">Crear Evidencia</h1>
    </div>

    <section class="section">

        <div class="card p-4 shadow-lg border-0" style="border-radius: 18px;">

            <form action="{{ route('evidencias.store') }}"
                method="POST"
                enctype="multipart/form-data"
                id="form-evidencias">

                @csrf

                {{-- ===================== --}}
                {{-- MATERIA / REVISION --}}
                {{-- ===================== --}}
                <div class="row g-3 mb-4">

                    <div class="col-md-6">
                        <label class="fw-bold small text-uppercase">Materia</label>

                        <select name="materia_id" class="form-control" required>
                            <option value="">Seleccione</option>
                            @foreach ($materias as $materia)
                            <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold small text-uppercase">Revisión</label>

                        <select name="revision_id" class="form-control" required>
                            <option value="">Seleccione</option>
                            @foreach ($revisiones as $revision)
                            <option value="{{ $revision->id }}">{{ $revision->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <hr>

                {{-- ===================== --}}
                {{-- DOCUMENTOS --}}
                {{-- ===================== --}}
                <h5 class="fw-bold text-primary mb-3">DOCUMENTOS</h5>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label>Instrumentación didáctica</label>
                        <input type="file" name="instrumentacion" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Reporte de inicio de curso</label>
                        <input type="file" name="reporte_inicio" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Acuerdos de clase</label>
                        <input type="file" name="acuerdos" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Lista de calificaciones</label>
                        <input type="file" name="calificaciones" class="form-control" required>
                    </div>

                    {{-- RAC --}}
                    <div class="col-md-12 mt-2">

                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <label class="fw-bold">Actividades de Regularización (RAC)</label>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="rac_na" name="rac_na">
                                <label class="form-check-label">No aplica</label>
                            </div>

                        </div>

                        <input type="file" name="rac" id="rac_input" class="form-control" required>

                    </div>

                </div>

                <hr class="my-4">

                {{-- ===================== --}}
                {{-- EVIDENCIAS --}}
                {{-- ===================== --}}
                <h5 class="fw-bold text-success mb-3">EVIDENCIAS</h5>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label>Examen diagnóstico</label>
                        <input type="file" name="examen_diagnostico" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Análisis del diagnóstico</label>
                        <input type="file" name="analisis_diagnostico" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Rúbricas del semestre</label>
                        <input type="file" name="rubricas" class="form-control" required>
                    </div>

                </div>

                {{-- ===================== --}}
                {{-- 🔥 TU DROPZONE ORIGINAL --}}
                {{-- ===================== --}}
                <div class="mt-4">

                    <div class="row-file-card p-4 rounded-3 style-dropzone"
                        id="dropzone-instrumentos">

                        <h6 class="fw-bold text-primary mb-1">
                            Evidencias de instrumentos de evaluación
                        </h6>

                        <p class="text-muted small mb-3">
                            Puedes agregar hasta 3 archivos PDF
                        </p>

                        <div class="row align-items-center">

                            <div class="col-md-5">

                                <input type="file"
                                    id="file-input-helper"
                                    class="d-none"
                                    accept="application/pdf"
                                    multiple>

                                <button type="button"
                                    class="btn btn-outline-primary rounded-pill fw-semibold small px-4 py-2 w-100"
                                    id="btn-seleccionar">

                                    Seleccionar archivos

                                </button>

                            </div>

                            <div class="col-md-7">

                                <div id="lista-archivos" class="d-flex flex-column gap-2">

                                    <span class="text-muted small" id="sin-archivos">
                                        Ningún archivo seleccionado
                                    </span>

                                </div>

                            </div>

                        </div>

                        <div id="hidden-inputs-container"></div>

                    </div>

                </div>

                <hr class="my-4">

                {{-- ===================== --}}
                {{-- BOTONES --}}
                {{-- ===================== --}}
                <div class="d-flex gap-2">

                    <a href="{{ route('evidencias') }}"
                        class="btn btn-light border px-4 rounded-pill">
                        Regresar
                    </a>

                    <button class="btn btn-primary px-4 rounded-pill">
                        Guardar Evidencia
                    </button>

                </div>

            </form>

        </div>

    </section>

</main>

{{-- ===================== --}}
{{-- RAC --}}
{{-- ===================== --}}
<script>
    const racCheck = document.getElementById('rac_na');
    const racInput = document.getElementById('rac_input');

    racCheck.addEventListener('change', function() {

        if (this.checked) {
            racInput.disabled = true;
            racInput.value = '';
            racInput.required = false;
        } else {
            racInput.disabled = false;
            racInput.required = true;
        }

    });
</script>

{{-- ===================== --}}
{{-- TU JS ORIGINAL DE INSTRUMENTOS --}}
{{-- ===================== --}}
<script>
    const helperInput = document.getElementById('file-input-helper');
    const btnSeleccionar = document.getElementById('btn-seleccionar');
    const listaArchivos = document.getElementById('lista-archivos');
    const hiddenContainer = document.getElementById('hidden-inputs-container');

    let archivos = [];

    btnSeleccionar.addEventListener('click', () => helperInput.click());

    helperInput.addEventListener('change', function() {

        for (let file of this.files) {

            if (file.type !== 'application/pdf') continue;

            if (archivos.length >= 3) break;

            archivos.push(file);
        }

        render();

        this.value = '';
    });

    function render() {

        listaArchivos.innerHTML = '';
        hiddenContainer.innerHTML = '';

        if (archivos.length === 0) {
            listaArchivos.innerHTML = `
            <span class="text-muted small">Ningún archivo seleccionado</span>
        `;
            return;
        }

        archivos.forEach((file, i) => {

            listaArchivos.innerHTML += `
            <div class="d-flex justify-content-between border p-2 rounded small">
                <span>${file.name}</span>
                <button type="button" onclick="removeFile(${i})">X</button>
            </div>
        `;
        });

        const dt = new DataTransfer();

        archivos.forEach(f => dt.items.add(f));

        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'instrumentos[]';
        input.multiple = true;
        input.files = dt.files;

        hiddenContainer.appendChild(input);
    }

    function removeFile(index) {
        archivos.splice(index, 1);
        render();
    }

    const combinacionesSubidas = @json($subidasArray);
    const revisionesOriginales = @json($revisiones);

    document.getElementById('materia_id').addEventListener('change', function() {

        const materiaId = this.value;
        const selectRevision = document.getElementById('revision_id');

        selectRevision.innerHTML = `<option value="">Seleccione revisión</option>`;

        let disponibles = 0;

        revisionesOriginales.forEach(revision => {

            const key = `${materiaId}-${revision.id}`;

            if (!combinacionesSubidas.includes(key)) {

                const option = document.createElement('option');
                option.value = revision.id;
                option.text = revision.nombre;

                selectRevision.appendChild(option);
                disponibles++;
            }
        });

        selectRevision.disabled = (disponibles === 0);

    });
</script>

@endsection