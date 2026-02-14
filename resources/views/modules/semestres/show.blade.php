@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
    <div class="card mt-4 mb-4">
        <div class="card-body">
            <div class="pagetitle">
                <h1>Eliminar Semestre</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('semestres') }}">Semestres</a></li>
                        <li class="breadcrumb-item active">Eliminar</li>
                    </ol>
                </nav>
            </div>

            <div class="alert alert-danger mt-4">
                <h5 class="fw-bold">Advertencia:</h5>
                <p>Vas a eliminar el semestre <strong>{{ $item->nombre }}</strong>. Esta acción no se puede deshacer.</p>
                <p>Si tiene materias asociadas, se eliminarán de este semestre.</p>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('semestres') }}" class="btn btn-outline-info me-2">
                    <i class="bi bi-x-circle me-1"></i> Cancelar
                </a>

                <button id="btnEliminar" class="btn btn-outline-danger">
                    <i class="bi bi-trash me-1"></i> Eliminar Semestre
                </button>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
document.getElementById('btnEliminar').addEventListener('click', function() {
    Swal.fire({
        title: 'Confirmar eliminación',
        text: 'Ingresa tu contraseña para eliminar este semestre',
        input: 'password',
        inputAttributes: { placeholder: 'Contraseña' },
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: (password) => {
            return fetch("{{ route('semestres.destroy', $item->id) }}", {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ password: password })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => { throw new Error(data.error || 'Contraseña incorrecta'); });
                }
                return response.json();
            })
            .catch(error => {
                Swal.showValidationMessage(error.message);
            });
        }
    }).then((result) => {
        if(result.isConfirmed){
            Swal.fire('¡Eliminado!', 'El semestre ha sido eliminado correctamente.', 'success')
                .then(()=> window.location.href = "{{ route('semestres') }}");
        }
    });
});
</script>
@endpush
