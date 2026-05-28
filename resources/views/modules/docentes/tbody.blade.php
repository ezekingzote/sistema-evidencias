@forelse($items as $item)
<tr>
    <td class="fw-bold text-uppercase">
        {{ $item->name }}
    </td>

    <td>
        {{ $item->email }}
    </td>
    <td>
        {{ $item->celular }}
    </td>
    <td class="fw-bold text-uppercase">
        {{ $item->departamento }}
    </td>

    <td>

        @if ($item->rol == 'admin')
        <span class="badge bg-danger">
            ADMIN
        </span>
        @else
        <span class="badge bg-info text-dark">
            DOCENTE
        </span>
        @endif

    </td>

    <td>

        @if ($item->rol == 'admin')

        <span class="badge bg-danger-subtle text-danger border border-danger">
            {{ strtoupper($item->cargo) }}
        </span>

        @else

        <span class="badge bg-primary-subtle text-primary border border-primary">
            DOCENTE
        </span>

        @endif

    </td>

    <td>

        <button type="button" class="btn btn-outline-secondary reset-btn" data-id="{{ $item->id }}">
            <i class="fa-solid fa-user-lock"></i>
        </button>

    </td>

    <td>
        <div class="form-check form-switch d-flex justify-content-center">
            <input class="form-check-input" type="checkbox" id="{{ $item->id }}"
                {{ $item->activo ? 'checked' : '' }}>
        </div>
    </td>



    <td>

        <a href="{{ route('docentes.edit', $item->id) }}" class="btn btn-outline-warning shadow-sm">
            <i class="fa-solid fa-user-pen"></i>
        </a>

    </td>

</tr>

@empty

<tr>

    <td colspan="10">

        No hay docentes registrados

    </td>

</tr>
@endforelse