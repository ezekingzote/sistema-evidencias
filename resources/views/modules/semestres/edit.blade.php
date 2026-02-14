@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="card mt-4 mb-4">
            <div class="card-body">
                <div class="pagetitle">
                    <h1>Editar Semestre</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('semestres') }}">Semestres</a></li>
                            <li class="breadcrumb-item active">Editar</li>
                        </ol>
                    </nav>
                </div>

                <section class="section">
                    <form action="{{ route('semestres.update', $item->id) }}" method="POST" id="formSemestreEdit">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Nombre del Semestre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control bg-light" readonly
                                    value="{{ $item->nombre }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Año</label>
                                <input type="number" name="anio" id="anio_manual" class="form-control"
                                    value="{{ $item->anio }}" min="{{ date('Y') - 1 }}" max="{{ date('Y') + 5 }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Periodo</label>
                                <select name="periodo" id="periodo_select" class="form-select" required>
                                    <option value="" disabled>Seleccione el periodo...</option>
                                    <option value="1" {{ $item->periodo == 1 ? 'selected' : '' }}>1 (ENE - JUN)
                                    </option>
                                    <option value="2" {{ $item->periodo == 2 ? 'selected' : '' }}>2 (JUL - DIC)
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Fecha Inicio</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required
                                    value="{{ $item->fecha_inicio }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Fecha Fin</label>
                                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required
                                    value="{{ $item->fecha_fin }}">
                            </div>

                            <div class="col-12 mt-4 text-center">
                                <a href="{{ route('semestres') }}" class="btn btn-outline-info me-2">
                                    <i class="bi bi-x-circle me-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-outline-dark px-5">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        const semestresExistentes = @json($semestres->map(fn($s) => ['anio' => $s->anio, 'periodo' => $s->periodo, 'id' => $s->id]));

        function generarNombre() {
            const anio = document.getElementById('anio_manual').value;
            const periodo = document.getElementById('periodo_select').value;

            if (!anio || !periodo) return;

            let textoPeriodo = '';
            const inicio = document.getElementById('fecha_inicio');
            const fin = document.getElementById('fecha_fin');

            if (periodo == '1') {
                textoPeriodo = 'ENE - JUN';
                inicio.min = `${anio}-01-01`;
                inicio.max = `${anio}-01-31`;
                fin.min = `${anio}-06-01`;
                fin.max = `${anio}-06-30`;
            } else if (periodo == '2') {
                textoPeriodo = 'JUL - DIC';
                inicio.min = `${anio}-07-01`;
                inicio.max = `${anio}-07-31`;
                fin.min = `${anio}-12-01`;
                fin.max = `${anio}-12-31`;
            }

            document.getElementById('nombre').value = `${anio}-${periodo} ${textoPeriodo}`;
        }

        function verificarDuplicado() {
            const anio = document.getElementById('anio_manual').value;
            const periodoSelect = document.getElementById('periodo_select');
            const btn = document.querySelector('button[type="submit"]');

            // Habilitar todas las opciones
            for (const option of periodoSelect.options)
                if (option.value != '') option.disabled = false;

            const duplicados = semestresExistentes.filter(s => s.anio == anio && s.id != {{ $item->id }});
            duplicados.forEach(s => {
                const opt = periodoSelect.querySelector(`option[value="${s.periodo}"]`);
                if (opt) opt.disabled = true;
            });
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
