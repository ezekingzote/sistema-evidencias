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
                    <div class="col-md-4">
                        <div class="list-group list-group-flush border rounded-4 p-2 bg-light sticky-top" style="top: 80px;">
                            <h6 class="px-3 py-2 text-uppercase text-muted small fw-bold">Secciones</h6>
                            @foreach ($items as $i => $doc)
                            @php
                            $evaluacion = $evidencia->evaluacion[$doc['key']] ?? [];

                            $esNA = !empty($evaluacion['na']);
                            $calificacion = $evaluacion['calificacion'] ?? null;
                            @endphp

                            <button type="button"
                                class="list-group-item list-group-item-action border-0 rounded-pill mb-1 documento-btn d-flex justify-content-between align-items-center {{ $i == 0 ? 'active text-white bg-primary' : '' }}"
                                data-target="doc-{{ $doc['key'] }}">

                                <span>
                                    <i class="bi bi-file-earmark-text me-2"></i>
                                    {{ $doc['nombre'] }}
                                </span>

                                @if($esNA)

                                <span class="badge bg-secondary">
                                    N/A
                                </span>

                                @elseif($calificacion !== null && $calificacion !== '')

                                @if($calificacion >= 70)

                                <i class="bi bi-check-circle-fill text-success fs-5"></i>

                                @else

                                <i class="bi bi-x-circle-fill text-danger fs-5"></i>

                                @endif

                                @endif

                            </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-8">
                        @foreach ($items as $i => $doc)
                        <div class="documento-panel {{ $i == 0 ? '' : 'd-none' }}" id="doc-{{ $doc['key'] }}">
                            <div class="card border border-light-subtle shadow-sm mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fw-bold text-primary mb-4">{{ $doc['nombre'] }}</h4>

                                    <div class="mb-4 bg-light border rounded overflow-hidden" style="height: 60vh;">
                                        @php
                                        // Unificamos la variable para saber si hay múltiples PDFs
                                        $archivosMultiples = $doc['archivos_multiples'] ?? [];
                                        @endphp

                                        @if (count($archivosMultiples) > 1)
                                        <div class="d-flex flex-column h-100 w-100">
                                            <div class="d-flex justify-content-between align-items-center mb-2 bg-white p-2 rounded border shadow-sm">
                                                <ul class="nav nav-pills gap-2" id="pills-{{ $doc['key'] }}" role="tablist">
                                                    @foreach ($archivosMultiples as $index => $pdf)
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link btn-sm {{ $index == 0 ? 'active text-white bg-primary' : 'bg-light text-dark border' }}"
                                                            id="btn-{{ $doc['key'] }}-{{ $index }}" type="button"
                                                            onclick="cambiarPdfMultiple('{{ asset('storage/' . $pdf) }}', 'iframe-{{ $doc['key'] }}', this, 'btn-{{ $doc['key'] }}')">
                                                            <i class="bi bi-file-earmark-pdf me-1"></i> Archivo {{ $index + 1 }}
                                                        </button>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                                <a href="{{ asset('storage/' . $archivosMultiples[0]) }}" target="_blank"
                                                    id="link-exterior-{{ $doc['key'] }}" class="btn btn-outline-secondary btn-sm"
                                                    title="Abrir en pantalla completa">
                                                    <i class="bi bi-box-arrow-up-right"></i>
                                                </a>
                                            </div>
                                            <div class="flex-grow-1 w-100 border rounded" style="background-color: #525659;">
                                                <iframe id="iframe-{{ $doc['key'] }}" src="{{ asset('storage/' . $archivosMultiples[0]) }}"
                                                    width="100%" height="100%" style="border:none; border-radius: 4px;">
                                                </iframe>
                                            </div>
                                        </div>

                                        @elseif(count($archivosMultiples) == 1)
                                        <iframe src="{{ asset('storage/' . $archivosMultiples[0]) }}" width="100%" height="100%" style="border:none;"></iframe>

                                        @elseif(!empty($doc['archivo']))
                                        <iframe src="{{ asset('storage/' . $doc['archivo']) }}" width="100%" height="100%" style="border:none;"></iframe>

                                        @else
                                        <div class="d-flex align-items-center justify-content-center text-muted h-100 bg-secondary-subtle">
                                            <div class="text-center">
                                                <i class="bi bi-file-earmark-x fs-1 mb-2 d-block"></i>
                                                <p class="mb-0">El docente no adjuntó este documento.</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="bg-primary-subtle p-3 rounded-3 form-evaluacion" data-key="{{ $doc['key'] }}">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="fw-bold text-primary mb-0"><i class="bi bi-pencil-square me-2"></i>Calificación del panel</h6>
                                            <span class="badge rounded-pill bg-success d-none status-badge shadow-sm transition-all" id="status-{{ $doc['key'] }}">Guardado ✓</span>
                                        </div>

                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input auto-save-input" type="checkbox" name="evaluaciones[{{ $doc['key'] }}][na]" value="1" id="na-{{ $doc['key'] }}" {{ isset($evidencia->evaluacion[$doc['key']]['na']) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold text-secondary" for="na-{{ $doc['key'] }}">No aplica (N/A)</label>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <input type="number" class="form-control auto-save-input" placeholder="Calificación (0-100)" name="evaluaciones[{{ $doc['key'] }}][calificacion]" value="{{ $evidencia->evaluacion[$doc['key']]['calificacion'] ?? '' }}" min="0" max="100">
                                            </div>
                                            <div class="col-md-9">
                                                <textarea rows="2" class="form-control auto-save-input" placeholder="Escribe tus observaciones aquí..." name="evaluaciones[{{ $doc['key'] }}][observaciones]">{{ $evidencia->evaluacion[$doc['key']]['observaciones'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 text-end border-top pt-4">
                    <a href="{{ route('seguimiento-academico') }}" class="btn btn-light border rounded-pill px-4 me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 shadow">
                        <i class="bi bi-check2-all me-1"></i> Finalizar y Aprobar/Rechazar Evidencia
                    </button>
                    <p class="small text-muted mt-2 mb-0">*(Los avances de calificación individuales ya están guardados)</p>
                </div>
            </form>
        </div>
    </section>
</main>

<script>
    // 1. Lógica para cambiar de panel en la barra lateral
    document.querySelectorAll('.documento-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.documento-btn').forEach(b => {
                b.classList.remove('active', 'text-white', 'bg-primary');
            });
            document.querySelectorAll('.documento-panel').forEach(p => p.classList.add('d-none'));
            this.classList.add('active', 'text-white', 'bg-primary');
            document.getElementById(this.getAttribute('data-target')).classList.remove('d-none');
        });
    });

    // 2. Lógica de Auto-guardado mediante Fetch API
    let debounceTimer;

    document.querySelectorAll('.auto-save-input').forEach(input => {
        input.addEventListener('input', triggerAutoSave);
        input.addEventListener('change', triggerAutoSave);
    });

    function triggerAutoSave(e) {
        clearTimeout(debounceTimer);

        const container = this.closest('.form-evaluacion');
        const key = container.getAttribute('data-key');
        const statusBadge = document.getElementById(`status-${key}`);
        statusBadge.classList.remove('d-none', 'bg-success', 'bg-danger');
        statusBadge.classList.add('bg-warning', 'text-dark');
        statusBadge.textContent = 'Guardando...';

        debounceTimer = setTimeout(() => {
            ejecutarGuardadoBackend(container, key, statusBadge);
        }, 1000);
    }

    function ejecutarGuardadoBackend(container, key, statusBadge) {
        const checkbox = container.querySelector('input[type="checkbox"]');
        const calificacion = container.querySelector('input[type="number"]').value;
        const observaciones = container.querySelector('textarea').value;

        fetch(`{{ route('evaluaciones.autosave', $evidencia->id) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    key: key,
                    na: checkbox.checked ? 1 : null,
                    calificacion: calificacion,
                    observaciones: observaciones
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('Error en el servidor');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    statusBadge.classList.remove('bg-warning', 'text-dark', 'bg-danger');
                    statusBadge.classList.add('bg-success', 'text-white');
                    statusBadge.textContent = 'Guardado ✓';
                    setTimeout(() => statusBadge.classList.add('d-none'), 3000);
                }
            })
            .catch(error => {
                statusBadge.classList.remove('bg-warning', 'text-dark', 'bg-success');
                statusBadge.classList.add('bg-danger', 'text-white');
                statusBadge.textContent = 'Error al guardar ⚠';
                console.error('Error Auto-guardado:', error);
            });
    }

    // 3. Función para cambiar el PDF en paneles con múltiples archivos
    function cambiarPdfMultiple(pdfUrl, iframeId, botonActivo, prefijoBotones) {
        const iframe = document.getElementById(iframeId);
        if (iframe) iframe.src = pdfUrl;

        const key = iframeId.replace('iframe-', '');
        const linkExterior = document.getElementById('link-exterior-' + key);
        if (linkExterior) linkExterior.href = pdfUrl;

        const botones = document.querySelectorAll(`[id^="${prefijoBotones}"]`);
        botones.forEach(btn => {
            btn.classList.remove('active', 'text-white', 'bg-primary');
            btn.classList.add('bg-light', 'text-dark', 'border');
        });

        botonActivo.classList.add('active', 'text-white', 'bg-primary');
        botonActivo.classList.remove('bg-light', 'text-dark', 'border');
    }
</script>

<style>
    .documento-panel {
        animation: fadeIn 0.4s ease;
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection