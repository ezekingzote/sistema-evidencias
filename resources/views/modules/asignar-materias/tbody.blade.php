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
        {{ $item->docente->name }}
    </td>

    <td>
        @php
        $partes = explode('-', $item->grupo);
        $ultimo = end($partes);
        $tieneLetra = (strlen($ultimo) === 1 && ctype_alpha($ultimo));
        $letraGrupo = $tieneLetra ? strtoupper($ultimo) : null;
        $grupoBase = $tieneLetra ? implode('-', array_slice($partes, 0, -1)) : $item->grupo;
        @endphp

        @if ($tieneLetra)
        <span class="grupo-badge grupo-badge-letra">
            <i class="bi bi-bookmark-fill me-2"></i>
            <span class="grupo-base">{{ $grupoBase }}</span>
            <span class="grupo-letra-tag ms-2">{{ $letraGrupo }}</span>
        </span>
        @else
        <span class="grupo-badge grupo-badge-unico">
            <i class="bi bi-bookmark me-2"></i>
            {{ $item->grupo }}
        </span>
        @endif
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
                class="btn btn-outline-warning btn-sm"
                style="border-radius: 8px;">
                <i class="bi bi-pencil"></i>
            </a>

            <a href="{{ route('asignar-materias.show', $item->id) }}"
                class="btn btn-outline-danger btn-sm"
                style="border-radius: 8px;">
                <i class="fa-solid fa-trash-can"></i>
            </a>
        </div>
    </td>

</tr>

@empty

{{-- Fila vacía: 7 columnas reales para que DataTables no se confunda --}}
<tr class="fila-vacia">
    <td colspan="7" class="text-center py-5">
        <div class="text-muted fw-bold">
            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
            No hay asignaciones registradas
        </div>
    </td>
</tr>

@endforelse

{{-- Estilos SOLO para los badges de grupo --}}
<style>
    .grupo-badge {
        display: inline-flex;
        align-items: center;
        padding: 8px 14px;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        line-height: 1;
        white-space: nowrap;
    }

    .grupo-badge-unico {
        background-color: #343a40;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(52, 58, 64, 0.25);
    }

    .grupo-badge-letra {
        background-color: #0d6efd;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
    }

    .grupo-letra-tag {
        background-color: #ffffff;
        color: #0d6efd;
        font-size: 0.9rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 8px;
        line-height: 1;
        box-shadow: inset 0 0 0 2px rgba(13, 110, 253, 0.15);
    }

    .grupo-base {
        letter-spacing: 0.5px;
    }
</style>