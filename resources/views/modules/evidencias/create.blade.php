@extends('layouts.main')

@section('titulo', 'Crear Nueva Evidencia')

@section('contenido')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Crear Nueva Evidencia</h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item"><a href="">Evidencias</a></li>
                <li class="breadcrumb-item active">Nueva</li>
            </ol>
        </nav>

    </div>

    <section class="section">

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
                                <p class="text-muted small mb-0">Complete todos los campos para registrar el archivo en el sistema.</p>
                            </div>

                        </div>
                    </div>

                    <div class="card-body p-4">

                        <form id="formNuevaEvidencia" class="row g-4" action="" method="POST" enctype="multipart/form-data">

                            @csrf

                            <div class="col-md-6">

                                <label class="form-label fw-bold small text-uppercase text-secondary">Revisión</label>

                                <div class="input-group">

                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-book text-muted"></i>
                                    </span>

                                    <select name="revision_id" class="form-control" required>

                                        <option value="" selected disabled>Seleccione revisión</option>

                                        @foreach($revisiones as $revision)

                                        <option value="{{ $revision->id }}">

                                            {{ $revision->nombre }}

                                        </option>

                                        @endforeach

                                    </select>

                                </div>
                            </div>
                            <div class="mb-3">

                                <label class="form-label"><strong>Carpeta Documentos (MAX 5MB)</strong></label>

                                <input type="file" name="documentos" class="form-control" webkitdirectory directory required>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">Carpeta Evidencias (MAX 5MB)</label>

                                <input type="file" name="evidencias" class="form-control" webkitdirectory directory required>


                            </div>

                            <div class="col-12">

                                <label class="form-label fw-bold small text-uppercase text-secondary">
                                    Tipo de Evidencia
                                </label>

                                <select name="tipo_evidencia" id="tipo_evidencia" class="form-select" style="border-left: 5px solid #0d6efd;" required>

                                    <option selected disabled>Seleccione el tipo de documento...</option>

                                    <optgroup label="Documentos">

                                        <option value="instrumentacion">
                                            Instrumentación didáctica completa, por asignatura.
                                        </option>

                                        <option value="calificaciones">
                                            Listas de calificaciones
                                        </option>

                                        <option value="reportes">
                                            Reportes y Acuerdos.
                                        </option>

                                    </optgroup>

                                    <optgroup label="Evidencias">

                                        <option value="tareas">
                                            Muestra de tareas y/o trabajos complementarios.
                                        </option>

                                        <option value="rubricas">
                                            Rúbricas utilizadas para tareas y trabajos por asignatura.
                                        </option>

                                        <option value="examen">
                                            Examen diagnóstico y análisis de este.
                                        </option>

                                    </optgroup>

                                </select>

                            </div>


                            <div class="col-12 mt-5 border-top pt-4 d-flex justify-content-between align-items-center gap-2">

                                <a href="" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-arrow-left me-1"></i> Regresar
                                </a>

                                <div class="d-flex gap-2">

                                    <button type="reset" class="btn btn-light px-4">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Limpiar
                                    </button>

                                    <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                        <i class="bi bi-cloud-upload me-2"></i>Subir Evidencia
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


@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const tipoEvidencia = document.getElementById('tipo_evidencia');

        const contenedorRubrica = document.getElementById('contenedorRubrica');


        tipoEvidencia.addEventListener('change', function() {

            if (this.value === 'instrumentacion') {

                contenedorRubrica.style.display = 'none';

            } else {

                contenedorRubrica.style.display = 'block';

            }

        });

    });
</script>

@endpush

@endsection