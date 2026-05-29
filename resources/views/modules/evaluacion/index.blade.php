@extends('layouts.main')

@section('titulo', 'Evaluar Evidencia')

@section('contenido')

<main id="main" class="main">

    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-primary">
            Evaluación de Evidencias
        </h1>
    </div>

    <section class="section">

        <div class="card border-0 shadow-lg p-4" style="border-radius: 18px;">

            <form method="POST" action="{{ route('evaluaciones.update', $evidencia->id) }}">
                @csrf
                @method('PUT')

                @php
                // Aseguramos que evaluación sea un array para evitar errores de sintaxis
                $evaluacionGuardada = is_array($evidencia->evaluacion) ? $evidencia->evaluacion : [];
                @endphp

                <div class="row">

                    {{-- ================================= --}}
                    {{-- SIDEBAR --}}
                    {{-- ================================= --}}
                    <div class="col-md-4">

                        <div class="border rounded-4 p-3 bg-light">

                            <h5 class="fw-bold text-primary mb-3">
                                Documentos
                            </h5>

                            <div class="d-flex flex-column gap-2">

                                @foreach($items as $i => $doc)

                                @php
                                // Recuperamos la calificación de la persistencia para el icono del Sidebar
                                $calificacion = $evaluacionGuardada[$doc['key']]['calificacion'] ?? null;
                                $esNaGuardado = isset($evaluacionGuardada[$doc['key']]['na']);
                                @endphp

                                <button
                                    type="button"
                                    class="btn btn-outline-primary text-start rounded-pill documento-btn d-flex justify-content-between align-items-center {{ $i == 0 ? 'active' : '' }}"
                                    data-target="doc-{{ $doc['key'] }}">

                                    <span>
                                        {{ $doc['nombre'] }}
                                    </span>

                                    <span>
                                        @if($esNaGuardado)
                                        <span class="badge bg-secondary text-uppercase" style="font-size: 0.7rem;">N/A</span>
                                        @elseif($calificacion !== null)
                                        @if($calificacion >= 70)
                                        <i class="fa-solid fa-circle-check text-success"></i>
                                        @else
                                        <i class="fa-solid fa-circle-xmark text-danger"></i>
                                        @endif
                                        @endif
                                    </span>

                                </button>

                                @endforeach

                            </div>

                        </div>

                    </div>

                    {{-- ================================= --}}
                    {{-- CONTENIDO --}}
                    {{-- ================================= --}}
                    <div class="col-md-8">

                        @foreach($items as $i => $doc)

                        @php
                        // Extraemos el sub-array de este documento si ya existe en la BD
                        $evaluado = $evaluacionGuardada[$doc['key']] ?? null;

                        // Lógica de N/A Automático si no hay archivos
                        $esNAAutomatico = false;
                        if (
                        (empty($doc['archivo']) && !isset($doc['instrumentos'])) ||
                        (isset($doc['instrumentos']) && count($doc['instrumentos']) == 0)
                        ) {
                        $esNAAutomatico = true;
                        }

                        // Determinamos si debe estar checkeado el switch de N/A
                        $marcarAsNA = $evaluacionGuardada
                        ? isset($evaluado['na'])
                        : $esNAAutomatico;
                        @endphp

                        <div class="documento-panel {{ $i != 0 ? 'd-none' : '' }}" id="doc-{{ $doc['key'] }}">

                            {{-- ============================= --}}
                            {{-- VISUALIZADOR PDF --}}
                            {{-- ============================= --}}
                            <div class="card border-0 shadow-sm mb-3">

                                <div class="card-body">

                                    <div class="d-flex justify-content-between align-items-center mb-3">

                                        <h5 class="fw-bold text-success mb-0">
                                            {{ $doc['nombre'] }}
                                        </h5>

                                        @if(!$esNAAutomatico)
                                        <a href="
                                                    @if($doc['key'] == 'instrumentos')
                                                        {{ asset('storage/' . ($doc['instrumentos'][0] ?? '')) }}
                                                    @else
                                                        {{ asset('storage/' . $doc['archivo']) }}
                                                    @endif
                                                "
                                            target="_blank"
                                            class="btn btn-dark rounded-pill">
                                            <i class="fa-solid fa-eye"></i> Abrir PDF
                                        </a>
                                        @endif

                                    </div>

                                    {{-- INSTRUMENTOS MULTIPLES --}}
                                    @if($doc['key'] == 'instrumentos')

                                    <div class="row">

                                        @forelse($doc['instrumentos'] as $pdf)

                                        <div class="col-md-4 mb-3">
                                            <iframe
                                                src="{{ asset('storage/' . $pdf) }}"
                                                width="100%"
                                                height="350"
                                                style="border:none; border-radius:12px;">
                                            </iframe>
                                        </div>

                                        @empty

                                        <div class="col-12">
                                            <div class="alert alert-secondary mb-0">
                                                No existen instrumentos cargados
                                            </div>
                                        </div>

                                        @endforelse

                                    </div>

                                    {{-- PDF INDIVIDUAL --}}
                                    @elseif(!empty($doc['archivo']))

                                    <iframe
                                        src="{{ asset('storage/' . $doc['archivo']) }}"
                                        width="100%"
                                        height="550"
                                        style="border:none; border-radius:12px;">
                                    </iframe>

                                    @else

                                    <div class="alert alert-secondary mb-0">
                                        No existe documento
                                    </div>

                                    @endif

                                </div>

                            </div>

                            {{-- ============================= --}}
                            {{-- FORMULARIO DE EVALUACIÓN --}}
                            {{-- ============================= --}}
                            <div class="card border-0 shadow-sm">

                                <div class="card-body">

                                    <div class="row g-3">

                                        {{-- SWITCH N/A --}}
                                        <div class="col-md-12">
                                            <div class="form-check form-switch">
                                                <input
                                                    class="form-check-input na-switch"
                                                    type="checkbox"
                                                    data-key="{{ $doc['key'] }}"
                                                    id="na_{{ $doc['key'] }}"
                                                    name="evaluaciones[{{ $doc['key'] }}][na]"
                                                    value="1"
                                                    {{ $marcarAsNA ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="na_{{ $doc['key'] }}">
                                                    No aplica
                                                </label>
                                            </div>
                                        </div>

                                        {{-- CALIFICACIÓN --}}
                                        <div class="col-md-4">
                                            <label class="fw-bold small text-uppercase" for="calificacion_{{ $doc['key'] }}">
                                                Calificación
                                            </label>
                                            <input
                                                type="number"
                                                min="0"
                                                max="100"
                                                class="form-control calificacion-input"
                                                id="calificacion_{{ $doc['key'] }}"
                                                name="evaluaciones[{{ $doc['key'] }}][calificacion]"
                                                value="{{ $evaluado['calificacion'] ?? '' }}"
                                                placeholder="0 - 100">
                                        </div>

                                        {{-- OBSERVACIONES --}}
                                        <div class="col-md-8">
                                            <label class="fw-bold small text-uppercase">
                                                Observaciones
                                            </label>
                                            <textarea
                                                class="form-control"
                                                rows="2"
                                                name="evaluaciones[{{ $doc['key'] }}][observaciones]"
                                                placeholder="Escribe observaciones...">{{ $evaluado['observaciones'] ?? '' }}</textarea>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        @endforeach

                    </div>

                </div>

                {{-- ================================= --}}
                {{-- ACCIONES INTERFAZ --}}
                {{-- ================================= --}}
                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('seguimiento-academico') }}" class="btn btn-light border rounded-pill px-4">
                        <i class="fa-solid fa-arrow-left"></i> Regresar
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar evaluación
                    </button>
                </div>

            </form>

        </div>

    </section>

</main>

<script>
    // =================================
    // INTERCAMBIO DE PANELES (SIDEBAR)
    // =================================
    const botones = document.querySelectorAll('.documento-btn');
    const paneles = document.querySelectorAll('.documento-panel');

    botones.forEach(btn => {
        btn.addEventListener('click', function() {
            botones.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const target = this.dataset.target;
            paneles.forEach(panel => panel.classList.add('d-none'));

            document.getElementById(target).classList.remove('d-none');
        });
    });

    // =================================
    // CONTROL DE CONTROLADORES N/A SWITCH
    // =================================
    const naSwitches = document.querySelectorAll('.na-switch');

    naSwitches.forEach(sw => {
        const key = sw.dataset.key;
        const input = document.getElementById('calificacion_' + key);

        // Estado inicial al cargar la página
        if (sw.checked && input) {
            input.disabled = true;
        }

        // Evento al interactuar dinámicamente
        sw.addEventListener('change', function() {
            if (this.checked) {
                input.disabled = true;
                input.value = ''; // Opcional: Limpia el valor si se marca N/A
            } else {
                input.disabled = false;
            }
        });
    });
    
</script>

@endsection