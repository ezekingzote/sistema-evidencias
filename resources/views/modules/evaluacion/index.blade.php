@extends('layouts.main')
@section('titulo', 'Evaluar Evidencia')
@section('contenido')

<main id="main" class="main">
    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-primary"><i class="bi bi-clipboard-check me-2"></i>Evaluación de Evidencias</h1>
    </div>

    <section class="section">
        <div class="card border-0 shadow-lg p-4" style="border-radius: 18px;">
            <form method="POST" action="{{ route('evaluaciones.update', $evidencia->id) }}">
                @csrf @method('PUT')

                <div class="row">
                    <!-- SIDEBAR DE NAVEGACIÓN -->
                    <div class="col-md-4">
                        <div class="list-group list-group-flush border rounded-4 p-2 bg-light">
                            <h6 class="px-3 py-2 text-uppercase text-muted small fw-bold">Secciones</h6>
                            @foreach($items as $i => $doc)
                            <button type="button"
                                class="list-group-item list-group-item-action border-0 rounded-pill mb-1 documento-btn {{ $i == 0 ? 'active' : '' }}"
                                data-target="doc-{{ $doc['key'] }}">
                                <i class="bi bi-file-earmark-text me-2"></i> {{ $doc['nombre'] }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- PANEL DE CONTENIDO -->
                    <div class="col-md-8">

                        @php

                        $grupos = [

                        'inicio' => [
                        'titulo' => 'Inicio del Curso',
                        'items' => [
                        'instrumentacion',
                        'reporte_inicio',
                        'examen_diagnostico',
                        'analisis_diagnostico',
                        'acuerdos'
                        ]
                        ],

                        'seguimiento' => [
                        'titulo' => 'Seguimiento',
                        'items' => [
                        'avance_programatico',
                        'instrumentos',
                        'rubricas',
                        'calificaciones'
                        ]
                        ],

                        'cierre' => [
                        'titulo' => 'Cierre',
                        'items' => [
                        'rac',
                        'asiste_seguimiento'
                        ]
                        ]

                        ];

                        @endphp

                        @foreach($grupos as $grupoKey => $grupo)

                        <div
                            class="grupo-panel {{ $loop->first ? '' : 'd-none' }}"
                            id="grupo-{{ $grupoKey }}">

                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">

                                    <h4 class="fw-bold text-primary mb-0">
                                        {{ $grupo['titulo'] }}
                                    </h4>

                                </div>
                            </div>

                            <div class="row g-3">

                                @foreach($items as $doc)

                                @if(in_array($doc['key'], $grupo['items']))

                                <div class="col-md-6">

                                    <div class="card h-100 border-0 shadow-sm">

                                        <div class="card-body">

                                            <h6 class="fw-bold mb-3">
                                                {{ $doc['nombre'] }}
                                            </h6>

                                            @if($doc['key'] == 'instrumentos' && !empty($doc['instrumentos']))

                                            <div class="d-grid gap-2 mb-3">

                                                @foreach($doc['instrumentos'] as $index => $pdf)

                                                <a
                                                    href="{{ asset('storage/'.$pdf) }}"
                                                    target="_blank"
                                                    class="btn btn-dark btn-sm">
                                                    Instrumento {{ $index + 1 }}
                                                </a>

                                                @endforeach

                                            </div>

                                            @elseif(!empty($doc['archivo']))

                                            <a
                                                href="{{ asset('storage/'.$doc['archivo']) }}"
                                                target="_blank"
                                                class="btn btn-dark btn-sm mb-3 w-100">
                                                Abrir PDF
                                            </a>

                                            @else

                                            <div class="alert alert-secondary py-2">
                                                Sin archivo
                                            </div>

                                            @endif

                                            <div class="form-check form-switch mb-3">

                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="evaluaciones[{{ $doc['key'] }}][na]"
                                                    value="1">

                                                <label class="form-check-label">
                                                    No aplica
                                                </label>

                                            </div>

                                            <input
                                                type="number"
                                                class="form-control mb-2"
                                                placeholder="Calificación"
                                                name="evaluaciones[{{ $doc['key'] }}][calificacion]">

                                            <textarea
                                                rows="2"
                                                class="form-control"
                                                placeholder="Observaciones"
                                                name="evaluaciones[{{ $doc['key'] }}][observaciones]"></textarea>

                                        </div>

                                    </div>

                                </div>

                                @endif

                                @endforeach

                            </div>

                        </div>

                        @endforeach

                    </div>
                </div>

                <div class="mt-4 text-end">
                    <a href="{{ route('seguimiento-academico') }}" class="btn btn-light border rounded-pill px-4">Regresar</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 shadow"><i class="bi bi-floppy"></i> Guardar Evaluación</button>
                </div>
            </form>
        </div>
    </section>
</main>

<script>
    // Lógica para cambiar de panel
    document.querySelectorAll('.documento-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.documento-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.documento-panel').forEach(p => p.classList.add('d-none'));

            this.classList.add('active');
            document.getElementById(this.getAttribute('data-target')).classList.remove('d-none');
        });
    });
</script>

<style>
    .documento-panel {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .btn-dark {
        background-color: #212529;
        border: none;
    }

    .btn-dark:hover {
        background-color: #000;
        transform: translateY(-2px);
    }
</style>
@endsection