@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">

    <div class="pagetitle mb-4">
        <h1>Asignar Materia</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    Asignaciones
                </li>
                <li class="breadcrumb-item active">
                    Nueva Asignación
                </li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="card shadow-sm border-0" style="border-radius: 18px; overflow: hidden;">

            <div class="card-header bg-white py-4 border-bottom">
                <div class="d-flex align-items-center">
                    <div class="p-3 rounded-3 me-3 bg-primary-light">
                        <i class="bi bi-journal-plus text-primary fs-4"></i>
                    </div>

                    <div>
                        <h5 class="card-title mb-0 p-0 fw-bold">
                            Registro de Nueva Asignación
                        </h5>
                        <small class="text-muted">
                            Asigne materias activas a docentes disponibles
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">

                @if (!$semestreActivo)

                    <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                        <div>
                            No hay un semestre activo configurado actualmente.
                        </div>
                    </div>

                @elseif($materias->isEmpty())

                    <div class="alert alert-info border-0 shadow-sm text-center">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Todas las materias activas ya fueron asignadas para el semestre
                        <strong>{{ $semestreActivo->nombre }}</strong>.
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('asignar-materias') }}"
                            class="btn btn-outline-primary px-4"
                            style="border-radius: 10px;">
                            <i class="bi bi-arrow-left me-2"></i> Volver a la lista
                        </a>
                    </div>

                @else

                    <form action="{{ route('asignar-materias.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="semestre_id" value="{{ $semestreActivo->id }}">

                        <div class="row g-4">

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-primary">
                                    Semestre Académico Activo
                                </label>

                                <input type="text"
                                    class="form-control bg-light fw-bold"
                                    value="{{ $semestreActivo->nombre }}"
                                    readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    Grupo Generado
                                </label>

                                <input type="text"
                                    name="grupo"
                                    id="grupo_input"
                                    class="form-control bg-light fw-bold text-primary"
                                    readonly
                                    required
                                    placeholder="Se generará al seleccionar la materia">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    Materia
                                </label>

                                <select name="materia_id"
                                    id="materia_select"
                                    class="form-select"
                                    required>

                                    <option value="">
                                        Seleccione una materia...
                                    </option>

                                    @foreach($materias as $materia)
                                        <option value="{{ $materia->id }}"
                                            data-carrera="{{ $materia->carrera }}"
                                            data-semestre="{{ $materia->semestre }}">
                                            {{ $materia->nombre }} ({{ $materia->carrera }})
                                        </option>
                                    @endforeach

                                </select>

                                <div class="form-text">
                                    Solo aparecen materias activas no asignadas en este semestre.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    Docente (Solo Activos)
                                </label>

                                <select name="docente_id"
                                    class="form-select"
                                    required>

                                    <option value="" selected disabled>
                                        Seleccione un docente...
                                    </option>

                                    @forelse ($docentes as $docente)
                                        <option value="{{ $docente->id }}">
                                            {{ $docente->name }} {{ $docente->apellido }}
                                        </option>
                                    @empty
                                        <option disabled>
                                            No hay docentes activos disponibles
                                        </option>
                                    @endforelse

                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold" for="alumnos">
                                    <i class="bi bi-people me-1"></i>
                                    Número de Alumnos
                                </label>

                                <div class="input-group">
                                    <input name="alumnos"
                                        id="alumnos"
                                        type="number"
                                        class="form-control"
                                        min="1"
                                        max="50"
                                        value="1"
                                        required>

                                    <span class="input-group-text">
                                        alumnos
                                    </span>
                                </div>
                            </div>

                            <div class="col-12 mt-5">
                                <div class="d-flex justify-content-end gap-3 border-top pt-4">

                                    <a href="{{ route('asignar-materias') }}"
                                        class="btn btn-outline-info px-4"
                                        style="border-radius: 10px;">
                                        <i class="fa-solid fa-xmark me-2"></i>
                                        Cancelar
                                    </a>

                                    <button type="submit"
                                        class="btn btn-outline-primary px-5 shadow-sm"
                                        style="border-radius: 10px;">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Registrar Asignación
                                    </button>

                                </div>
                            </div>

                        </div>
                    </form>

                @endif

            </div>
        </div>
    </section>

</main>

<style>
    .bg-primary-light {
        background-color: #e7f1ff;
    }

    .card {
        border-radius: 18px;
        transition: all 0.3s ease;
    }

    .form-control,
    .form-select,
    .input-group-text {
        border-radius: 10px;
        padding: 0.65rem 1rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.08);
    }

    .btn {
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-outline-primary:hover {
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
    }

    .btn-outline-info:hover {
        box-shadow: 0 4px 12px rgba(13, 202, 240, 0.15);
    }

    .alert {
        border-radius: 14px;
    }
</style>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const sessionError = "{{ session('error') }}";

        const siglasCarreras = {
            'Ingeniería en Sistemas Computacionales': 'SIS',
            'Ingeniería Industrial': 'IND',
            'Ingeniería en Gestión Empresarial': 'IGE',
            'Licenciatura en Turismo': 'TM'
        };

        $('#materia_select').on('change', function() {
            const opcion = $(this).find('option:selected');

            const carreraNom = opcion.data('carrera');
            const semestre = opcion.data('semestre');

            if (!carreraNom || !semestre) {
                $('#grupo_input').val('');
                return;
            }

            const sigla = siglasCarreras[carreraNom] || 'GEN';

            $('#grupo_input').val(sigla + '-' + semestre);
        });

        if (sessionError) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: sessionError,
                confirmButtonColor: '#d33'
            });
        }
    });
</script>
@endpush