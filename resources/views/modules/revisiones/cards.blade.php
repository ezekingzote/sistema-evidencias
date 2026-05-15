@foreach ($revisiones as $revision)

<div class="col-12 col-md-6 col-lg-4">

    <div class="card shadow-sm border-0 h-100 revision-card"
         style="border-radius: 18px; overflow: hidden;">

        <div class="card-header bg-white border-0 pt-4 pb-2 px-4">

            <div class="d-flex justify-content-between align-items-start">

                <div>
                    <div class="mb-2">
                        <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                            Revisión Académica
                        </span>
                    </div>

                    <h4 class="mb-1 fw-bold"
                        style="color: #012970;">
                        {{ $revision->nombre }}
                    </h4>

                    <small class="text-muted">
                        Control y seguimiento docente
                    </small>
                </div>

                <div class="form-check form-switch">
                    <input
                        class="form-check-input cambiarEstado"
                        type="checkbox"
                        data-id="{{ $revision->id }}"
                        {{ $revision->activo ? 'checked' : '' }}>
                </div>

            </div>

        </div>

        <div class="card-body px-4 pb-4 d-flex flex-column">

            @if($semestreActivo)

                <div class="alert alert-light border small mb-4"
                     style="border-radius: 12px;">
                    <div class="fw-semibold text-dark mb-1">
                        Semestre activo
                    </div>
                    <div class="text-primary fw-bold">
                        {{ $semestreActivo->nombre }}
                    </div>
                </div>

                <div class="mb-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">
                            Materias activas
                        </span>
                        <span class="badge bg-success px-3 py-2">
                            {{ $semestreActivo->materias->where('activo',1)->count() }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">
                            Materias asignadas
                        </span>
                        <span class="badge bg-info text-dark px-3 py-2">
                            {{ $semestreActivo->materias->where('pivot.asignada',1)->count() }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">
                            Estado actual
                        </span>

                        @if($revision->activo)
                            <span class="badge bg-success px-3 py-2">
                                Activa
                            </span>
                        @else
                            <span class="badge bg-secondary px-3 py-2">
                                Inactiva
                            </span>
                        @endif
                    </div>

                </div>

                <div class="mt-auto">

                    <a href="{{ route('seguimiento-academico') }}"
                       class="btn btn-outline-success w-100 py-2 shadow-sm"
                       style="border-radius: 12px;">
                        <i class="bi bi-graph-up-arrow me-2"></i>
                        Ir a Seguimiento Académico
                    </a>

                </div>

            @else

                <div class="text-center py-4">

                    <div class="mb-3">
                        <i class="bi bi-hourglass-split fs-1 text-secondary"></i>
                    </div>

                    <h6 class="fw-bold text-dark">
                        Sin semestre activo
                    </h6>

                    <p class="text-muted small mb-0">
                        Debes activar un semestre para habilitar el seguimiento académico.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endforeach


<style>
    .revision-card {
        transition: all 0.3s ease;
    }

    .revision-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08) !important;
    }

    .form-check-input {
        width: 3rem;
        height: 1.5rem;
        cursor: pointer;
    }

    .badge {
        font-size: 0.80rem;
        border-radius: 10px;
        font-weight: 600;
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }
</style>