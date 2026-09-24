@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">

    <div class="pagetitle mb-4">
        <h1>Asignar Materia</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Asignaciones</li>
                <li class="breadcrumb-item active">Nueva Asignación</li>
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
                        <h5 class="card-title mb-0 p-0 fw-bold">Registro de Nueva Asignación</h5>
                        <small class="text-muted">Asigne materias activas a docentes disponibles</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">

                @if (!$semestreActivo)
                <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                    <div>No hay un semestre activo configurado actualmente.</div>
                </div>
                @elseif($materias->isEmpty())
                <div class="alert alert-info border-0 shadow-sm text-center">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    No hay materias activas disponibles para asignar en el semestre
                    <strong>{{ $semestreActivo->nombre }}</strong>.
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('asignar-materias') }}" class="btn btn-outline-primary px-4"
                        style="border-radius: 10px;">
                        <i class="bi bi-arrow-left me-2"></i> Volver a la lista
                    </a>
                </div>
                @else

                <form action="{{ route('asignar-materias.store') }}" method="POST" id="form_asignacion" autocomplete="off">
                    @csrf
                    <input type="hidden" name="semestre_id" value="{{ $semestreActivo->id }}">

                    <div class="row g-4">

                        {{-- Semestre activo --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-primary">Semestre Académico Activo</label>
                            <input type="text" class="form-control bg-light fw-bold"
                                value="{{ $semestreActivo->nombre }}" readonly>
                        </div>

                        {{-- Grupo final --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Grupo Asignado</label>
                            <input type="text" id="grupo_base"
                                class="form-control bg-light fw-bold text-primary"
                                readonly placeholder="Seleccione una materia...">
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Grupo final que se guardará.
                            </div>
                        </div>

                        {{-- Materia --}}
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Materia</label>
                            <select name="materia_id" id="materia_select" class="form-select" required>
                                <option value="">Seleccione una materia...</option>
                                @foreach ($materias as $materia)
                                <option value="{{ $materia->id }}"
                                    data-carrera="{{ $materia->carrera }}"
                                    data-semestre="{{ $materia->semestre }}"
                                    data-tiene-asignaciones="{{ $materia->tiene_asignaciones ? 1 : 0 }}"
                                    data-total-grupos="{{ $materia->total_grupos_definidos }}"
                                    data-letras-usadas='@json($materia->letras_usadas)'
                                    data-letras-disponibles='@json($materia->letras_disponibles)'>
                                    {{ $materia->nombre }} ({{ $materia->carrera }})
                                    @if ($materia->tiene_asignaciones)
                                    — Ocupadas: {{ implode(', ', $materia->letras_usadas) }}
                                    @endif
                                </option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                Solo aparecen materias activas con grupos disponibles.
                            </div>
                        </div>

                        {{-- ========== BLOQUE 1: CANTIDAD DE GRUPOS ========== --}}
                        <div class="col-12" id="bloque_cantidad" style="display: none;">
                            <div class="p-4 rounded-3" style="background-color: #f8f9fa; border: 1px dashed #ced4da;">

                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-diagram-3 me-1"></i>
                                    Configuración inicial
                                </h6>

                                <label class="form-label fw-bold">
                                    ¿Cuántos grupos tendrá esta materia?
                                </label>

                                <div class="d-flex align-items-center gap-3">
                                    <input type="number" id="total_grupos" class="form-control fw-bold"
                                        min="1" max="26" value="1" style="max-width: 120px;">
                                    <span class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        De 1 a 26 grupos. Si es 1, será grupo único (sin letra).
                                    </span>
                                </div>

                            </div>
                        </div>

                        {{-- ========== BLOQUE 2: CHECKLIST DE LETRAS ========== --}}
                        <div class="col-12" id="bloque_letras" style="display: none;">
                            <div class="p-4 rounded-3" style="background-color: #f0f7ff; border: 1px solid #b6d4fe;">

                                <h6 class="fw-bold mb-3 text-primary">
                                    <i class="bi bi-check2-square me-1"></i>
                                    Seleccione el grupo a asignar
                                </h6>

                                <div id="letras_list" class="d-flex flex-wrap gap-3"></div>

                                <div class="form-text mt-3" id="letras_help">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Seleccione la letra del grupo que está registrando.
                                </div>

                            </div>
                        </div>

                        {{-- Campo real --}}
                        <input type="hidden" name="grupo" id="grupo_input" required>
                        <input type="hidden" name="total_grupos" id="total_grupos_input" value="">

                        {{-- Docente --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Docente (Solo Activos)</label>
                            <select name="docente_id" class="form-select" required>
                                <option value="">Seleccione un docente</option>
                                @foreach ($docentes as $docente)
                                <option value="{{ $docente->id }}">
                                    {{ $docente->name }}
                                    @if ($docente->rol === 'admin') - ADMINISTRADOR @endif
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Alumnos --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold" for="alumnos">
                                <i class="bi bi-people me-1"></i> Número de Alumnos
                            </label>
                            <div class="input-group">
                                <input name="alumnos" id="alumnos" type="number" class="form-control"
                                    min="1" max="100" value="1" required>
                                <span class="input-group-text">alumnos</span>
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="col-12 mt-5">
                            <div class="d-flex justify-content-end gap-3 border-top pt-4">
                                <a href="{{ route('asignar-materias') }}" class="btn btn-outline-info px-4"
                                    style="border-radius: 10px;">
                                    <i class="fa-solid fa-xmark me-2"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-outline-primary px-5 shadow-sm"
                                    style="border-radius: 10px;">
                                    <i class="bi bi-check-circle me-2"></i> Registrar Asignación
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

    /* ─── Checkboxes de letras ─── */
    .letra-check {
        position: relative;
    }

    .letra-check input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
        pointer-events: none;
    }

    .letra-check label {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        border: 2px solid #dee2e6;
        background-color: #fff;
        color: #495057;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
        outline: none;
    }

    /* Hover suave pero SIN pintar azul */
    .letra-check label:hover {
        border-color: #86b7fe;
        background-color: #f0f7ff;
    }

    /* ⚠️ Nunca pintar azul por focus */
    .letra-check input[type="checkbox"]:focus+label {
        border-color: #dee2e6;
        background-color: #fff;
        box-shadow: none;
    }

    /* ⚠️ Solo azul cuando está REALMENTE marcado */
    .letra-check input[type="checkbox"]:checked+label {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #fff;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
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

        let baseGrupo = '';
        let letrasDisponibles = [];

        // ── Al cambiar la materia ─────────────────────────────────
        $('#materia_select').on('change', function() {
            const opcion = $(this).find('option:selected');

            const carreraNom = opcion.data('carrera');
            const semestre = opcion.data('semestre');
            const tieneAsignaciones = parseInt(opcion.data('tiene-asignaciones')) === 1;
            letrasDisponibles = opcion.data('letras-disponibles') || [];

            resetTodo();

            if (!carreraNom || !semestre) return;

            const sigla = siglasCarreras[carreraNom] || 'GEN';
            baseGrupo = sigla + '-' + semestre;

            if (!tieneAsignaciones) {
                // ── PRIMERA VEZ: preguntar cuántos grupos ──
                $('#bloque_cantidad').show();
            } else {
                // ── YA TIENE ASIGNACIONES: directo a las letras disponibles ──
                renderizarLetras(letrasDisponibles);
                $('#bloque_letras').show();
            }
        });

        // ── Al cambiar la cantidad de grupos ─────────────────────
        $('#total_grupos').on('input change', function() {
            const cantidad = parseInt($(this).val()) || 0;

            $('#grupo_input').val('');
            $('#grupo_base').val('');
            $('#letras_list').empty();
            $('#bloque_letras').hide();

            if (cantidad < 1 || cantidad > 26) return;

            $('#total_grupos_input').val(cantidad);

            if (cantidad === 1) {
                // ── Grupo único: sin letra ──
                $('#grupo_input').val(baseGrupo);
                $('#grupo_base').val(baseGrupo);
            } else {
                // ── Varios grupos: mostrar las primeras N letras SIN marcar ninguna ──
                const letrasAMostrar = [];
                for (let i = 0; i < cantidad; i++) {
                    letrasAMostrar.push(String.fromCharCode(65 + i)); // A, B, C...
                }

                renderizarLetras(letrasAMostrar);

                // Grupo vacío hasta que el usuario elija una letra
                $('#grupo_input').val('');
                $('#grupo_base').val('');

                $('#bloque_letras').show();
            }
        });

        // ── Renderizar checklist (SIN marcar nada, SIN focus) ──
        function renderizarLetras(letras) {
            $('#letras_list').empty();

            const lista = letras || letrasDisponibles;

            if (lista.length === 0) return;

            lista.forEach(function(letra) {
                const html = `
                        <div class="letra-check">
                            <input type="checkbox" 
                                   id="letra_${letra}" 
                                   value="${letra}" 
                                   class="letra-input"
                                   autocomplete="off">
                            <label for="letra_${letra}">${letra}</label>
                        </div>
                    `;
                $('#letras_list').append(html);
            });

            // ⚠️ Forzar: ningún check activo, ningún foco
            $('#letras_list').find('.letra-input')
                .prop('checked', false)
                .blur();

            // Quitar foco del elemento activo por si el navegador lo puso
            if (document.activeElement) {
                document.activeElement.blur();
            }

            $('#letras_help').html(
                '<i class="bi bi-info-circle me-1"></i> Seleccione la letra del grupo que está registrando.'
            );
        }

        // ── Al marcar/desmarcar una letra ────────────────────────
        $(document).on('change', '.letra-input', function() {
            if ($(this).is(':checked')) {
                $('.letra-input').not(this).prop('checked', false);

                const letra = $(this).val();
                $('#grupo_input').val(baseGrupo + '-' + letra);
                $('#grupo_base').val(baseGrupo + '-' + letra);
            } else {
                if ($('.letra-input:checked').length === 0) {
                    $('#grupo_input').val('');
                    $('#grupo_base').val('');
                }
            }
        });

        // ── Reset general ────────────────────────────────────────
        function resetTodo() {
            $('#bloque_cantidad').hide();
            $('#bloque_letras').hide();
            $('#letras_list').empty();
            $('#grupo_input').val('');
            $('#grupo_base').val('');
            $('#total_grupos_input').val('');
            $('#total_grupos').val(1);
        }

        // ── Validación al enviar ─────────────────────────────────
        $('#form_asignacion').on('submit', function(e) {
            if (!$('#grupo_input').val()) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Seleccione un grupo',
                    text: 'Debe elegir una letra antes de continuar.',
                    confirmButtonColor: '#0d6efd'
                });
                return false;
            }
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