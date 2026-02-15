@forelse ($items as $item)
    <tr>

        <td>
            {{ $item->semestre->nombre }}
        </td>

        <td>
            {{ $item->materia->nombre }}
        </td>

        <td>
            {{ $item->docente->name }}
        </td>

        <td>
            {{ $item->grupo }}
        </td>

        <td>

            <div class="form-check form-switch d-flex justify-content-center">

                <input class="form-check-input chkToggle" type="checkbox" data-id="{{ $item->id }}"
                    {{ $item->activo ? 'checked' : '' }}>

            </div>

        </td>

        <td>

            <a href="{{ route('asignar-materias.edit', $item->id) }}" class="btn btn-outline-warning btn-sm">
                <i class="bi bi-pencil"></i>
            </a>
            <a href="{{ route('asignar-materias.show', $item->id) }}" class="btn btn-outline-danger btn-sm">
                <i class="fa-solid fa-trash-can"></i>
            </a>

        </td>

    </tr>

@empty

    <tr>

        <td colspan="6">

            No hay asignaciones registradas

        </td>

    </tr>
@endforelse
