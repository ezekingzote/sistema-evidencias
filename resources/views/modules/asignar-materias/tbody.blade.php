@forelse ($items as $item)
<tr>
    <td>
        <span class="fw-semibold text-dark">
            {{ $item->semestre->nombre }}
        </span>
    </td>

    <td>
        <span class="fw-semibold">
            {{ $item->materia->nombre }}
        </span>
    </td>

    <td>
        {{ $item->docente->user->name ?? 'Sin docente' }}
    </td>

    <td>
        <span class="badge bg-light text-dark border px-3 py-2">
            {{ $item->grupo }}
        </span>
    </td>

    <td>
        <span class="fw-bold text-primary">
            {{ $item->alumnos }}
        </span>
    </td>

    <td>
        <div class="form-check form-switch d-flex justify-content-center">
            <input
                class="form-check-input chkToggle"
                type="checkbox"
                data-id="{{ $item->id }}"
                {{ $item->activo ? 'checked' : '' }}>
        </div>
    </td>

    <td>
        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('asignar-materias.edit', $item->id) }}"
                class="btn btn-outline-warning btn-sm">
                <i class="bi bi-pencil"></i>
            </a>

            <a href="{{ route('asignar-materias.show', $item->id) }}"
                class="btn btn-outline-danger btn-sm">
                <i class="fa-solid fa-trash-can"></i>
            </a>
        </div>
    </td>
</tr>
@empty
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td class="text-center"><strong>Sin registros</strong></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
@endforelse