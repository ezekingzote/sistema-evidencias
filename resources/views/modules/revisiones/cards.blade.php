@foreach ($revisiones as $revision)

<div class="col-12 col-md-6 col-lg-3">

    <div class="card shadow-sm h-100 border-start border-primary border-4">

        <div class="card-body d-flex flex-column p-3">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="card-title mb-0"
                    style="color: #012970; font-weight: 700;">
                    {{ $revision->nombre }}
                </h5>
                <div class="form-check form-switch">
                    <input class="form-check-input cambiarEstado"
                        type="checkbox"
                        data-id="{{ $revision->id }}"
                        {{ $revision->activo ? 'checked' : '' }}>
                </div>

            </div>

            @if($semestreActivo)

            <p class="small text-muted mb-2">
                Semestre activo:
                <strong>
                    {{ $semestreActivo->nombre }}
                </strong>
            </p>

            <ul class="list-unstyled small mb-4">

                <li>
                    <strong>Materias activas:</strong>
                    {{ $semestreActivo->materias->where('activo',1)->count() }}
                </li>

                <li>
                    <strong>Materias asignadas:</strong>
                    {{ $semestreActivo->materias->where('pivot.asignada',1)->count() }}
                </li>

            </ul>

            @else

            <div class="alert alert-light text-center small mt-3">
                Esperando semestre activo
            </div>

            @endif

        </div>

    </div>

</div>

@endforeach