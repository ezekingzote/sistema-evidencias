@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="card mt-4 mb-4">
            <div class="card-body">
                <div class="pagetitle">
                    <h1>Crear Nuevo semestre</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Registrar nuevo semestre</li>
                        </ol>
                    </nav>
                </div>

                <section class="section">
                    <form action="{{ route('semestre.store') }}" id="formSemestre" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Nombre del Semestre</label>
                                <input name="nombre" id="nombre" type="text" class="form-control bg-light" readonly>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Año</label>
                                <input type="number" id="anio_manual" name="anio" class="form-control"
                                    value="{{ date('Y') }}" min="{{ date('Y') - 1 }}" max="{{ date('Y') + 5 }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Periodo</label>
                                <select id="periodo_select" name="periodo" class="form-select" required>
                                    <option value="" selected disabled>Seleccione el periodo...</option>
                                    <option value="1">1 (ENERO - JUNIO)</option>
                                    <option value="2">2 (JULIO - DICIEMBRE)</option>
                                </select>
                                <small id="error_duplicado" class="text-danger" style="display:none;">Este periodo ya está
                                    registrado para este año.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Fecha Inicio</label>
                                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Fecha Fin</label>
                                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                            </div>

                            <div class="col-12 mt-4 text-center">
                                <a href="{{ route('semestres') }}" class="btn btn-outline-info">
                                    <i class="bi bi-x-circle me-2"></i> Cancelar
                                </a>
                                <button type="submit" id="btnGuardar" class="btn btn-outline-dark px-5">
                                    <i class="fa-solid fa-floppy-disk"></i> Registrar Semestre</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
        </section>

    </main>
@endsection

@push('scripts')
    <script>

        const semestresExistentes = @json($semestres->map(fn($s) => ['anio' => $s->anio, 'periodo' => $s->periodo]));

        function generarNombre() {
            const anio = document.getElementById('anio_manual').value;
            const periodo = document.getElementById('periodo_select').value;

            if (!anio || !periodo) return;

            const inicio = document.getElementById('fecha_inicio');
            const fin = document.getElementById('fecha_fin');
            let textoPeriodo = '';

            if (periodo == '1') {
                textoPeriodo = 'ENE - JUN';
                inicio.min = `${anio}-01-01`;
                inicio.max = `${anio}-01-31`;
                inicio.value = `${anio}-01-01`;
                fin.min = `${anio}-06-01`;
                fin.max = `${anio}-06-30`;
                fin.value = `${anio}-06-30`;
            }

            if (periodo == '2') {
                textoPeriodo = 'JUL - DIC';
                inicio.min = `${anio}-07-01`;
                inicio.max = `${anio}-07-31`;
                inicio.value = `${anio}-07-01`;
                fin.min = `${anio}-12-01`;
                fin.max = `${anio}-12-31`;
                fin.value = `${anio}-12-31`;
            }

            document.getElementById('nombre').value = `${anio}-${periodo} ${textoPeriodo}`;
        }

        function verificarDuplicado() {
            const anio = document.getElementById('anio_manual').value;
            const periodoSelect = document.getElementById('periodo_select');
            const error = document.getElementById('error_duplicado');
            const btn = document.getElementById('btnGuardar');

            if (!anio) return;


            for (const option of periodoSelect.options) {
                if (option.value !== "") option.disabled = false;
            }

            const duplicados = semestresExistentes.filter(s => s.anio == anio);
            duplicados.forEach(s => {
                const opt = periodoSelect.querySelector(`option[value="${s.periodo}"]`);
                if (opt) opt.disabled = true;
            });

            const periodoActual = periodoSelect.value;
            if (duplicados.some(s => s.periodo == periodoActual)) {
                error.style.display = 'block';
                btn.disabled = true;
            } else {
                error.style.display = 'none';
                btn.disabled = false;
            }
        }

        document.getElementById('anio_manual').addEventListener('change', () => {
            generarNombre();
            verificarDuplicado();
        });

        document.getElementById('periodo_select').addEventListener('change', () => {
            generarNombre();
            verificarDuplicado();
        });

        document.addEventListener('DOMContentLoaded', () => {
            generarNombre();
            verificarDuplicado();
        });
    </script>
@endpush
