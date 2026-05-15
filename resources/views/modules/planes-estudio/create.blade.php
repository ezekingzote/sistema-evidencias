@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Crear Nueva Ponderación</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('planes-estudio') }}">Home</a></li>
                    <li class="breadcrumb-item active">Registrar una ponderacion nueva</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <form action="#" method="POST" id="formPonderacion">
                            @csrf
                            <input type="hidden" name="materia_id" value="{{ $materia->id }}">
                            <input type="hidden" name="unidad" value="{{ $unidad }}">

                            <div class="card-body p-4">
                                <div class="row g-3 mb-4 p-3 rounded-3 bg-light border">
                                    <div class="col-md-6">
                                        <label for="materia_nombre"
                                            class="form-label fw-bold text-secondary small text-uppercase">Materia
                                            Académica</label>
                                        <input type="text" id="materia_nombre" class="form-control" readonly
                                            value="{{ $materia->nombre }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="unidad_display"
                                            class="form-label fw-bold text-secondary small text-uppercase">Unidad a
                                            Evaluar</label>
                                        <input type="text" id="unidad_display" class="form-control" readonly
                                            value="Unidad {{ $unidad }}">
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-borderless align-middle" id="tablaPonderaciones">
                                        <thead class="table-light">
                                            <tr class="text-secondary small text-uppercase">
                                                <th style="width: 45%;" class="ps-3 py-3">Actividad / Criterio</th>
                                                <th style="width: 15%;" class="text-center py-3">Ponderación (%)</th>
                                                <th style="width: 30%;" class="py-3">Instrumento de Evaluación</th>
                                                <th style="width: 10%;" class="text-center py-3">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyInstrumentacion">
                                            <tr class="border-bottom fila-criterio">
                                                <td class="ps-3">
                                                    <input type="text" name="actividades[]"
                                                        class="form-control form-control-sm border-0 bg-light"
                                                        placeholder="Ej. Examen" required>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm w-75 mx-auto">
                                                        <input type="number" name="porcentajes[]"
                                                            class="form-control border-0 bg-light text-center fw-bold input-porcentaje"
                                                            min="1" max="100" value="0" required>
                                                        <span class="input-group-text border-0 bg-light small">%</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="instrumentos[]"
                                                        class="form-control form-control-sm border-0 bg-light"
                                                        placeholder="Ej. Rúbrica" required>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-link text-danger p-0 btn-eliminar"
                                                        title="Eliminar criterio">
                                                        <i class="bi bi-x-circle-fill fs-5"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-grid d-md-block mt-3">
                                    <button type="button" id="btnAgregarCriterio"
                                        class="btn btn-sm btn-outline-primary px-3">
                                        <i class="bi bi-plus-lg me-1"></i> Agregar nuevo criterio
                                    </button>
                                </div>
                            </div>

                            <div class="card-footer bg-light border-0 p-4">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <h4 id="textoTotalPorcentaje" class="mb-0 me-3 fw-bold text-danger">0%</h4>
                                            <div>
                                                <div class="progress" style="width: 150px; height: 8px;">
                                                    <div id="barraProgreso" class="progress-bar bg-danger"
                                                        style="width: 0%"></div>
                                                </div>
                                                <span id="mensajePorcentaje"
                                                    class="small text-danger fw-semibold mt-1 d-block">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Falta 100% para el
                                                    total
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                        <a href="{{ route('planes-estudio') }}"
                                            class="btn btn-outline-danger me-2">Cancelar</a>
                                        <button type="submit" id="btnGuardar" class="btn btn-outline-success px-4 shadow"
                                            disabled>Guardar Ponderación</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

</main>@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tbody = document.getElementById('tbodyInstrumentacion');
            const btnAgregar = document.getElementById('btnAgregarCriterio');
            const textoTotal = document.getElementById('textoTotalPorcentaje');
            const barraProgreso = document.getElementById('barraProgreso');
            const mensajePorcentaje = document.getElementById('mensajePorcentaje');
            const btnGuardar = document.getElementById('btnGuardar');

            // Función para calcular el total
            function recalcularTotal() {
                let total = 0;
                const inputs = document.querySelectorAll('.input-porcentaje');

                inputs.forEach(input => {
                    const valor = parseFloat(input.value) || 0;
                    total += valor;
                });

                // Actualizar textos y barra
                textoTotal.textContent = total + '%';
                barraProgreso.style.width = (total > 100 ? 100 : total) + '%';

                if (total === 100) {
                    // Todo correcto
                    textoTotal.classList.replace('text-danger', 'text-success');
                    barraProgreso.classList.replace('bg-danger', 'bg-success');
                    mensajePorcentaje.classList.replace('text-danger', 'text-success');
                    mensajePorcentaje.innerHTML =
                        '<i class="bi bi-check-circle-fill me-1"></i> Total alcanzado (100%)';
                    btnGuardar.disabled = false; // Habilitamos el botón de guardar
                    btnGuardar.classList.replace('btn-outline-success', 'btn-success');
                    btnGuardar.classList.add('text-white');
                } else if (total > 100) {
                    // Se pasó del límite
                    textoTotal.classList.replace('text-success', 'text-danger');
                    barraProgreso.classList.replace('bg-success', 'bg-danger');
                    mensajePorcentaje.classList.replace('text-success', 'text-danger');
                    let excede = total - 100;
                    mensajePorcentaje.innerHTML =
                        `<i class="bi bi-exclamation-triangle-fill me-1"></i> Excedes el límite por ${excede}%`;
                    btnGuardar.disabled = true; // Deshabilitamos
                } else {
                    // Falta para el 100
                    textoTotal.classList.replace('text-success', 'text-danger');
                    barraProgreso.classList.replace('bg-success', 'bg-danger');
                    mensajePorcentaje.classList.replace('text-success', 'text-danger');
                    let falta = 100 - total;
                    mensajePorcentaje.innerHTML =
                        `<i class="bi bi-exclamation-triangle-fill me-1"></i> Falta ${falta}% para el total`;
                    btnGuardar.disabled = true; // Deshabilitamos
                }
            }

            // Escuchar cambios en los inputs existentes
            tbody.addEventListener('input', function(e) {
                if (e.target.classList.contains('input-porcentaje')) {
                    recalcularTotal();
                }
            });

            // Eliminar fila
            tbody.addEventListener('click', function(e) {
                // Buscamos si se hizo clic en el botón o en el ícono 'i' dentro del botón
                const btnEliminar = e.target.closest('.btn-eliminar');
                if (btnEliminar) {
                    // Verificamos que al menos quede una fila
                    if (tbody.querySelectorAll('.fila-criterio').length > 1) {
                        btnEliminar.closest('.fila-criterio').remove();
                        recalcularTotal();
                    } else {
                        alert('Debe existir al menos un criterio de evaluación.');
                    }
                }
            });

            // Agregar nueva fila
            btnAgregar.addEventListener('click', function() {
                const nuevaFila = `
                <tr class="border-bottom fila-criterio">
                    <td class="ps-3">
                        <input type="text" name="actividades[]" class="form-control form-control-sm border-0 bg-light" placeholder="Ej. Examen" required>
                    </td>
                    <td>
                        <div class="input-group input-group-sm w-75 mx-auto">
                            <input type="number" name="porcentajes[]" class="form-control border-0 bg-light text-center fw-bold input-porcentaje" min="1" max="100" value="0" required>
                            <span class="input-group-text border-0 bg-light small">%</span>
                        </div>
                    </td>
                    <td>
                        <input type="text" name="instrumentos[]" class="form-control form-control-sm border-0 bg-light" placeholder="Ej. Rúbrica" required>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-link text-danger p-0 btn-eliminar" title="Eliminar criterio">
                            <i class="bi bi-x-circle-fill fs-5"></i>
                        </button>
                    </td>
                </tr>
            `;
                tbody.insertAdjacentHTML('beforeend', nuevaFila);
            });
            recalcularTotal();
        });
    </script>
@endsection
