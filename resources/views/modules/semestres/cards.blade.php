@forelse ($semestres as $semestre)
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card shadow-sm h-100 border-start border-primary border-4">
            <div class="card-body d-flex flex-column p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0" style="color: #012970; font-weight: 700;">
                        {{ $semestre->nombre }}
                    </h5>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="{{ $semestre->id }}"
                            {{ $semestre->activo ? 'checked' : '' }} data-inicio="{{ $semestre->fecha_inicio }}"
                            data-fin="{{ $semestre->fecha_fin }}">
                    </div>
                </div>

                <p class="text-muted mb-3 small text-uppercase fw-bold" style="letter-spacing:1px;font-size:0.75rem;">
                    {{ $semestre->carrera }}
                </p>

                <ul class="list-unstyled small mb-4">
                    <li class="mb-2"><i class="bi bi-journal-text me-2"></i><strong>Año:</strong>
                        {{ $semestre->anio }}</li>

                    <li>
                        <i class="bi bi-calendar-check me-2"></i><strong>Estatus:</strong>
                        <span class="badge rounded-pill"
                            style="background-color: {{ $semestre->activo ? '#e0f8e9' : '#fde2e2' }};
                                   color: {{ $semestre->activo ? '#28a745' : '#dc3545' }};
                                   font-size:0.7rem;">
                            {{ $semestre->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </li>

                    <li>
                        <strong>Materias Activas:</strong>
                        {{ $semestre->materias_activas_count }}
                    </li>

                    <li>
                        <strong>Materias Asignadas:</strong>
                        {{ $semestre->materias_asignadas_count }}
                    </li>

                    <li>
                        <strong>Materias Por Asignar:</strong>
                        {{ $semestre->materias_por_asignar_count }}
                    </li>



                    <li class="mt-3"><i class="fa-solid fa-hexagon-nodes me-2"></i><strong>Acciones</strong>
                        <a href="{{ route('semestres.edit', $semestre->id) }}"
                            class="btn btn-sm btn-outline-warning {{ $semestre->activo ? 'disabled' : '' }}"
                            {{ $semestre->activo ? 'aria-disabled="true" title=Semestre activo, no se puede editar' : '' }}>
                            <i class="fa-solid fa-file-pen"></i>
                        </a>

                        <a href="{{ route('semestres.show', $semestre->id) }}"
                            class="btn btn-sm btn-outline-danger {{ $semestre->activo ? 'disabled' : '' }}"
                            {{ $semestre->activo ? 'aria-disabled="true" title=Semestre activo, no se puede eliminar' : '' }}>
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </li>

                </ul>

                <div class="mt-auto">
                    <div class="dropdown w-100">
                        <button type="button"
                            class="btn btn-outline-primary dropdown-toggle btn-sm w-100 d-flex align-items-center justify-content-center"
                            data-bs-toggle="dropdown" aria-expanded="false" style="border-radius:6px;">
                            <i class="bi bi-eye me-2"></i> Ver Materias
                        </button>

                        <ul class="dropdown-menu w-100">
                            @forelse ($semestre->materias as $materia)
                                <li>
                                    <span class="dropdown-item">
                                        {{ $materia->nombre }}
                                    </span>
                                </li>
                            @empty
                                <li>
                                    <span class="dropdown-item text-muted">
                                        No hay materias asignadas
                                    </span>
                                </li>
                            @endforelse
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12 text-center fw-bold mt-4">
        <div class="alert alert-warning">No hay semestres registrados.</div>
    </div>
@endforelse
