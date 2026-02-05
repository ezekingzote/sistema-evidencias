@foreach ($semestres as $semestre)
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card shadow-sm h-100 border-start border-primary border-4">
            <div class="card-body d-flex flex-column p-3">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0" style="color: #012970; font-weight: 700;">
                        {{ $semestre->nombre }}
                    </h5>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="{{ $semestre->id }}"
                            {{ $semestre->activo ? 'checked' : '' }}>
                    </div>
                </div>

                <p class="text-muted mb-3 small text-uppercase fw-bold"
                    style="letter-spacing: 1px; font-size: 0.75rem;">
                    {{ $semestre->carrera }}
                </p>

                <ul class="list-unstyled small mb-4">
                    <li class="mb-2">
                        <i class="bi bi-journal-text me-2"></i>
                        <strong>Año:</strong> {{ $semestre->anio }}
                    </li>

                    <li class="mb-2">
                        <i class="bi bi-journal-text me-2"></i>
                        <strong>Materias:</strong> {{ $semestre->materias_count }}
                    </li>

                    <li>
                        <i class="bi bi-calendar-check me-2"></i>
                        <strong>Estatus:</strong>

                        <span class="badge rounded-pill"
                            style="
            background-color: {{ $semestre->activo ? '#e0f8e9' : '#fde2e2' }};
            color: {{ $semestre->activo ? '#28a745' : '#dc3545' }};
            font-size: 0.7rem;
        ">
                            {{ $semestre->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </li>


                    <li class="mt-3">
                        <i class="fa-solid fa-hexagon-nodes me-2"></i>
                        <strong>Acciones</strong>
                        <a href="{{ route('semestres.edit', $semestre->id) }}" class="btn btn-sm btn-outline-warning"><i
                                class="fa-solid fa-file-pen"></i></a>
                        <a href="{{ route('semestres.show', $semestre->id) }}" class="btn btn-sm btn-outline-danger"><i
                                class="fa-solid fa-trash"></i></a>
                    </li>



                </ul>

                <div class="mt-auto">
                    <div class="dropdown w-100">
                        <button type="button"
                            class="btn btn-outline-primary dropdown-toggle btn-sm w-100 d-flex align-items-center justify-content-center"
                            data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 6px;">
                            <i class="bi bi-eye me-2"></i> Ver Materias
                        </button>

                        <ul class="dropdown-menu w-100 shadow-sm">
                            @forelse ($semestre->materias as $materia)
                                <li>
                                    <span class="dropdown-item-text small">
                                        <i class="fa-solid fa-book-open me-2 text-primary"></i> {{ $materia->nombre }}
                                    </span>
                                </li>
                            @empty
                                <li><span class="dropdown-item-text small text-muted">No hay materias</span></li>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endforeach
