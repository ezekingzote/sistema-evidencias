@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Asignar Materia</h1>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <section class="section">
            <div class="card shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    
                    @if(!$semestreActivo)
                        <div class="alert alert-warning">No hay un semestre activo configurado.</div>
                    @else
                        <form action="{{ route('asignar-materias.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="semestre_id" value="{{ $semestreActivo->id }}">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-primary">Semestre Académico Activo</label>
                                    <input type="text" class="form-control bg-light fw-bold" 
                                           value="{{ $semestreActivo->nombre }}" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Grupo Generado</label>
                                    <input type="text" name="grupo" id="grupo_input" class="form-control bg-light fw-bold text-primary" 
                                           readonly required placeholder="Se generará al seleccionar la materia">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Materia</label>
                                    <select id="materia_select" name="materia_id" class="form-select" required>
                                        <option value="" selected disabled>Seleccione la materia...</option>
                                        @foreach ($materias as $materia)
                                            <option value="{{ $materia->id }}">
                                                {{ $materia->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Docente</label>
                                    <select name="docente_id" class="form-select" required>
                                        <option value="" selected disabled>Seleccione un docente...</option>
                                        @foreach ($docentes as $docente)
                                            <option value="{{ $docente->id }}">{{ $docente->name }} {{ $docente->apellido }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mt-4 text-center">
                                    <a href="{{ route('asignar-materias') }}" class="btn btn-outline-info px-4"><i class="fa-solid fa-xmark"></i> Cancelar</a>
                                    <button type="submit" class="btn btn-outline-primary px-5 shadow-sm">
                                        <i class="bi bi-check-circle me-1"></i> Registrar Asignación
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const siglasCarreras = {
            'INGENIERIA EN SISTEMAS COMPUTACIONALES': 'SIS',
            'INGENIERIA INDUSTRIAL': 'IND',
            'INGENIERIA EN GESTION EMPRESARIAL': 'IGE',
            'LICENCIATURA EN TURISMO': 'TM'
        };

        $('#materia_select').on('change', function() {
            const $opcion = $(this).find('option:selected');
            const carreraNom = $opcion.data('carrera');
            const semestre = $opcion.data('semestre') || '';

            if (carreraNom) {
                const sigla = siglasCarreras[carreraNom] || 'GEN';
                // El grupo ahora es solo SIGLA-SEMESTRE (ej: SIS-9)
                const grupoFinal = sigla + '-' + semestre;
                $('#grupo_input').val(grupoFinal);
            }
        });
    });
</script>
@endpush