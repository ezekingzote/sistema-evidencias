@foreach ($items as $item)
    <tr>
        <td>{{ $item->nombre }}</td>
        <td>{{ $item->clave }}</td>
        <td class="text-center">{{ $item->unidades }}</td>
        <td>{{ $item->carrera }}</td>
        <td class="text-center">{{ $item->semestre }}</td>
        <td class="text-center">
            <div class="form-check form-switch d-flex justify-content-center">
                <input class="form-check-input chkToggle" type="checkbox" id="chk{{ $item->id }}"
                    data-id="{{ $item->id }}" {{ $item->activo ? 'checked' : '' }}>
            </div>
        </td>
        <td>
            <a href="{{ route('materias.edit', $item->id) }}" class="btn btn-outline-warning">
                <i class="fa-solid fa-user-pen"></i>
            </a>
            <a href="{{ route('materias.show', $item->id) }}" class="btn btn-outline-danger">
                <i class="fa-solid fa-trash-can"></i>
            </a>
        </td>
    </tr>
@endforeach
