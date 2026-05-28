@extends('layouts.main')

@section('titulo', 'Evaluar Evidencia')

@section('contenido')

@php
$documentos = $evidenciaActual->documentos ?? [];
$evidencias = $evidenciaActual->evidencias ?? [];

// FIX: asegurar arrays reales
if (is_string($documentos)) {
$documentos = json_decode($documentos, true) ?? [];
}

if (is_string($evidencias)) {
$evidencias = json_decode($evidencias, true) ?? [];
}

/*
ORDEN NUEVO DE ITEMS
*/
$items = [
'instrumentacion' => 'Instrumentación didáctica',
'reporte_inicio' => 'Reporte inicio de curso',
'examen_diagnostico' => 'Examen diagnóstico',
'analisis_diagnostico' => 'Análisis del diagnóstico',
'acuerdos' => 'Acuerdos de clase',
'avance_programatico' => 'Avance programático',
'instrumentos' => 'Evidencia de instrumentos (3 muestras)',
'rubricas' => 'Rúbricas del semestre',
'calificaciones' => 'Lista de calificaciones',
'regularizacion' => 'Actividades de regularización',
'seguimiento' => 'Seguimiento'
];
@endphp

<main id="main" class="main">

    <div class="container-fluid">

        <form method="POST" action="{{ route('evidencias-guardar-evaluacion', $evidenciaActual->id) }}">
            @csrf
            @method('PUT')

            {{-- ===================== CARRUSEL ===================== --}}
            <div id="carouselDocs" class="carousel slide mb-4">

                <div class="carousel-inner">

                    @foreach(array_chunk($items, 3, true) as $index => $grupo)

                    <div class="carousel-item @if($index==0) active @endif">

                        <div class="row">

                            @foreach($grupo as $key => $label)

                            @php
                            $file = $documentos[$key] ?? $evidencias[$key] ?? null;
                            @endphp

                            <div class="col-md-4">

                                <div class="border rounded p-2 bg-white shadow-sm">

                                    <div class="text-center fw-bold small mb-2">
                                        {{ $label }}
                                    </div>

                                    @if($file)

                                    <iframe
                                        src="{{ route('archivos.ver', base64_encode($file)) }}"
                                        width="100%"
                                        height="180"
                                        style="border:0">
                                    </iframe>

                                    @else

                                    <div class="text-center text-muted py-5 small">
                                        Sin archivo
                                    </div>

                                    @endif

                                </div>

                            </div>

                            @endforeach

                        </div>

                    </div>

                    @endforeach

                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselDocs" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#carouselDocs" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>

            </div>

            {{-- ===================== TABLA ===================== --}}
            <div class="card shadow-sm">

                <div class="card-header bg-dark text-white">
                    Evaluación de Evidencias
                </div>

                <div class="card-body p-0">

                    <table class="table table-bordered align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Documento</th>
                                <th width="100">N/A</th>
                                <th width="120">Calificación</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($items as $key => $label)

                            <tr>

                                <td class="fw-semibold">{{ $label }}</td>

                                <td class="text-center">
                                    <input type="checkbox"
                                        class="na-toggle"
                                        data-key="{{ $key }}"
                                        name="items[{{ $key }}][na]">
                                </td>

                                <td>
                                    <input type="number"
                                        min="0"
                                        max="100"
                                        step="0.1"
                                        class="form-control calif-{{ $key }}"
                                        name="items[{{ $key }}][calificacion]">
                                </td>

                                <td>
                                    <input type="text"
                                        class="form-control obs-{{ $key }}"
                                        name="items[{{ $key }}][observaciones]">
                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- BOTON --}}
            <div class="mt-4 text-end">
                <button class="btn btn-primary px-5">
                    Guardar evaluación
                </button>
            </div>

        </form>

    </div>

</main>

<script>
    document.querySelectorAll('.na-toggle').forEach(el => {
        el.addEventListener('change', function() {

            const key = this.dataset.key;
            const cal = document.querySelector('.calif-' + key);
            const obs = document.querySelector('.obs-' + key);

            if (this.checked) {
                // Cambiado de .disabled a .readOnly
                cal.readOnly = true;
                obs.readOnly = true;

                // Estilo visual opcional para que parezca desactivado
                cal.classList.add('bg-light');
                obs.classList.add('bg-light');

                cal.value = '';
                obs.value = 'N/A';
            } else {
                cal.readOnly = false;
                obs.readOnly = false;

                cal.classList.remove('bg-light');
                obs.classList.remove('bg-light');

                obs.value = '';
            }
        });
    });
</script>

@endsection