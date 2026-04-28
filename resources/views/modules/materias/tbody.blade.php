@foreach ($items as $item)

<tr>

    <td class="fw-semibold text-dark">
        {{ $item->nombre }}
    </td>

    <td>
        <span class="badge bg-light text-dark border px-3 py-2">
            {{ $item->clave }}
        </span>
    </td>

    <td class="text-center">
        <span class="fw-semibold text-primary">
            {{ $item->semestre }}
        </span>
    </td>

    <td>
        {{ $item->carrera }}
    </td>

    <td class="text-center">
        <span class="badge rounded-pill bg-info bg-opacity-10 text-info border border-info px-3 py-2">
            {{ $item->unidades }} Unidades
        </span>
    </td>

    <td class="text-center">

        <div class="form-check form-switch d-flex justify-content-center">

            <input
                class="form-check-input chkToggle"
                type="checkbox"
                id="chk{{ $item->id }}"
                data-id="{{ $item->id }}"
                {{ $item->activo ? 'checked' : '' }}
            >

        </div>

    </td>

    <td>

        <div class="d-flex justify-content-center gap-2">

            <a
                href="{{ route('materias.edit', $item->id) }}"
                class="btn btn-outline-warning btn-sm rounded-pill px-3"
            >
                <i class="fa-solid fa-user-pen"></i>
            </a>

            <a
                href="{{ route('materias.show', $item->id) }}"
                class="btn btn-outline-danger btn-sm rounded-pill px-3"
            >
                <i class="fa-solid fa-trash-can"></i>
            </a>

        </div>

    </td>

</tr>

@endforeach