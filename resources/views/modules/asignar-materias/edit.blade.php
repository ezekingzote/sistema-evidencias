@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">

    <div class="pagetitle mb-4">
        <h1>Editar Asignación</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('asignar-materias') }}">Asignar Materias</a>
                </li>
                <li class="breadcrumb-item active">
                    Editar
                </li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="card shadow-sm border-0" style="border-radius: 18px; overflow: hidden;">

            <div class="card-header bg-white py-4 border-bottom">
                <div class="d-flex align-items-center">
                    <div class="p-3 rounded-3 me-3 bg-warning-light">
                        <i class="bi bi-pencil-square text-warning fs-4"></i>
                    </div>

                    <div>
                        <h5 class="card-title mb-0 p-0 fw-bold">
                            Modificar Asignación
                        </h5>
                        <small class="text-muted">
                            Actualice la información de la asignación seleccionada
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">

                @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm">
                    <div class="fw-bold mb-2">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Se encontraron errores:
                    </div>

                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('asignar-materias.update', $item->id) }}"
                    method="POST"
                    id="formAsignacionEdit"
                    autocomplete="off">

                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                Semestre
                            </label>

                            <input type="text"
                                class="form-control bg-light fw-semibold"
                                readonly
                                value="{{ $item->semestre->nombre }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                Materia
                            </label>

                            <input type="text"
                                class="form-control bg-light fw-semibold"
                                readonly
                                value="{{ $item->materia->nombre }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">
                                Grupo Actual
                            </label>

                            <input type="text"
                                class="form-control bg-light fw-semibold"
                                readonly
                                value="{{ $item->grupo }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">
                                Docente
                            </label>

                            <select name="docente_id"
                                class="form-select select2"
                                required>

                                <option value="" disabled>
                                    Seleccione docente...
                                </option>

                                @foreach ($docentes as $docente)
                                <option value="{{ $docente->id }}"
                                    {{ $item->docente_id == $docente->id ? 'selected' : '' }}>
                                    {{ $docente->name }}
                                </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold" for="alumnos">
                                <i class="bi bi-people me-1"></i>
                                Cantidad de Alumnos
                            </label>

                            <div class="input-group">
                                <input name="alumnos"
                                    id="alumnos"
                                    type="number"
                                    class="form-control"
                                    min="1"
                                    max="100"
                                    value="{{ old('alumnos', $item->alumnos) }}"
                                    required>

                                <span class="input-group-text">
                                    Alumnos
                                </span>
                            </div>
                        </div>

                        {{-- ════════════════════════════════════════════════════ --}}
                        {{-- CONFIGURACIÓN DE GRUPOS (solo en la PRIMERA)      --}}
                        {{-- ════════════════════════════════════════════════════ --}}
                        @if ($esPrimera)
                        <div class="col-12">
                            <div class="p-4 rounded-3"
                                style="background-color: #f8f9fa; border: 1px dashed #ced4da;">

                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-diagram-3 me-1"></i>
                                    Configuración de grupos
                                </h6>

                                <div class="row g-4">

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Total de grupos para esta materia
                                        </label>

                                        <input type="number"
                                            name="total_grupos"
                                            id="total_grupos"
                                            class="form-control fw-bold"
                                            min="1"
                                            max="26"
                                            value="{{ old('total_grupos', $totalGrupos) }}"
                                            style="max-width: 140px;">

                                        <div class="form-text mt-2">
                                            <i class="bi bi-info-circle me-1"></i>
                                            De 1 a 26 grupos. Si es 1, se guardará como grupo único (sin letra).
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Letras actualmente asignadas
                                        </label>

                                        <div class="d-flex flex-wrap gap-2 mt-1">
                                            @if (count($letrasUsadas) > 0)
                                            @foreach ($letrasUsadas as $letra)
                                            <span class="badge bg-primary px-3 py-2"
                                                style="border-radius: 8px; font-size: 0.95rem;">
                                                {{ $letra }}
                                            </span>
                                            @endforeach
                                            @else
                                            <span class="text-muted fst-italic">
                                                Ninguna aún (grupo sin letra)
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                {{-- ═══════════════════════════════════════════════════ --}}
                                {{-- CHECKLIST DE LETRAS NUEVAS (solo si AUMENTA)      --}}
                                {{-- ═══════════════════════════════════════════════════ --}}
                                <div id="bloque_letras_nuevas" class="mt-4" style="display: none;">
                                    <div class="p-4 rounded-3"
                                        style="background-color: #f0f7ff; border: 1px solid #b6d4fe;">

                                        <h6 class="fw-bold mb-3 text-primary">
                                            <i class="bi bi-check2-square me-1"></i>
                                            Asignar un grupo nuevo ahora (opcional)
                                        </h6>

                                        <p class="text-muted small mb-3">
                                            Estás aumentando los grupos. Puedes asignar una letra nueva ahora mismo,
                                            o dejarlo para después desde <strong>Nueva Asignación</strong>.
                                        </p>

                                        <div id="letras_nuevas_list" class="d-flex flex-wrap gap-3"></div>

                                        <div class="form-text mt-3">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Puedes no marcar ninguna si prefieres asignar más tarde.
                                        </div>

                                    </div>
                                </div>

                                {{-- Aviso de reducción --}}
                                <div id="aviso_reduccion" class="alert alert-warning border-0 mt-3 mb-0 shadow-sm" style="display: none;">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    Estás <strong>reduciendo</strong> los grupos. Si hay letras fuera del nuevo rango,
                                    deberás eliminarlas primero.
                                </div>

                            </div>
                        </div>
                        @endif

                        <div class="col-12 mt-5">
                            <div class="d-flex justify-content-end gap-3 border-top pt-4">

                                <a href="{{ route('asignar-materias') }}"
                                    class="btn btn-outline-secondary px-4"
                                    style="border-radius: 10px;">
                                    <i class="bi bi-x-circle me-2"></i>
                                    Cancelar
                                </a>

                                <button type="submit"
                                    class="btn btn-outline-warning px-5 shadow-sm fw-bold"
                                    style="border-radius: 10px;">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Guardar Cambios
                                </button>

                            </div>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </section>

</main>

<style>
    .bg-warning-light {
        background-color: #fff3cd;
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
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.08);
    }

    .btn {
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-outline-warning:hover {
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.15);
    }

    .btn-outline-secondary:hover {
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.15);
    }

    .alert {
        border-radius: 14px;
    }

    /* Checkboxes de letras (mismo estilo que create) */
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

    .letra-check label:hover {
        border-color: #86b7fe;
        background-color: #f0f7ff;
    }

    .letra-check input[type="checkbox"]:focus+label {
        border-color: #dee2e6;
        background-color: #fff;
        box-shadow: none;
    }

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

        // Inicializar select2
        if ($.fn.select2) {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        }

        const totalGruposOriginal = {
            {
                $totalGrupos
            }
        };
        const letrasUsadas = @json($letrasUsadas);
        const baseGrupo = "{{ $baseGrupo }}";

        // Todas las letras A-Z
        const todasLasLetras = [];
        for (let i = 0; i < 26; i++) {
            todasLasLetras.push(String.fromCharCode(65 + i));
        }

        // ─── Detectar cambios en total_grupos ───
        $('#total_grupos').on('input change', function() {
            const nuevoTotal = parseInt($(this).val()) || 0;

            ocultarBloques();

            if (nuevoTotal < 1 || nuevoTotal > 26) return;

            if (nuevoTotal === totalGruposOriginal) {
                // Sin cambios
                return;
            }

            if (nuevoTotal > totalGruposOriginal) {
                // ─── AUMENTO: mostrar checklist de letras nuevas ───
                mostrarLetrasNuevas(nuevoTotal);
            } else {
                // ─── REDUCCIÓN: mostrar aviso ───
                $('#aviso_reduccion').show();
            }
        });

        function ocultarBloques() {
            $('#bloque_letras_nuevas').hide();
            $('#aviso_reduccion').hide();
            $('#letras_nuevas_list').empty();
            $('input[name="letra_nueva"]').remove();
        }

        function mostrarLetrasNuevas(nuevoTotal) {
            // Letras permitidas con el nuevo total
            const letrasPermitidas = todasLasLetras.slice(0, nuevoTotal);

            // Letras nuevas que aún no están asignadas
            const letrasNuevas = letrasPermitidas.filter(l => !letrasUsadas.includes(l));

            if (letrasNuevas.length === 0) {
                // No hay letras nuevas que asignar (raro, pero posible)
                return;
            }

            $('#letras_nuevas_list').empty();

            letrasNuevas.forEach(function(letra) {
                const html = `
                    <div class="letra-check">
                        <input type="checkbox" 
                               id="letra_nueva_${letra}" 
                               value="${letra}" 
                               class="letra-nueva-input"
                               autocomplete="off">
                        <label for="letra_nueva_${letra}">${letra}</label>
                    </div>
                `;
                $('#letras_nuevas_list').append(html);
            });

            // Input hidden para enviar la letra elegida
            $('#letras_nuevas_list').append('<input type="hidden" name="letra_nueva" id="letra_nueva_input" value="">');

            // Quitar foco
            $('#letras_nuevas_list').find('.letra-nueva-input').prop('checked', false).blur();
            if (document.activeElement) document.activeElement.blur();

            $('#bloque_letras_nuevas').show();
        }

        // ─── Al marcar una letra nueva ───
        $(document).on('change', '.letra-nueva-input', function() {
            if ($(this).is(':checked')) {
                // Desmarcar las demás
                $('.letra-nueva-input').not(this).prop('checked', false);

                const letra = $(this).val();
                $('#letra_nueva_input').val(letra);
            } else {
                // Si desmarcó la única, limpiar
                if ($('.letra-nueva-input:checked').length === 0) {
                    $('#letra_nueva_input').val('');
                }
            }
        });

        // ─── Validación antes de enviar ───
        $('#formAsignacionEdit').on('submit', function(e) {
            const totalInput = $('#total_grupos');

            if (totalInput.length > 0) {
                const val = parseInt(totalInput.val()) || 0;
                if (val < 1 || val > 26) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Número inválido',
                        text: 'El total de grupos debe estar entre 1 y 26.',
                        confirmButtonColor: '#ffc107'
                    });
                    return false;
                }
            }
        });
    });
</script>
@endpush