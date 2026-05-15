@extends('layouts.main')

@section('titulo', 'Editar Evidencias')

@section('contenido')
<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="fw-bold text-warning">Editar Evidencias</h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item"><a href="">Evidencias</a></li>
                <li class="breadcrumb-item active">Editar</li>
            </ol>
        </nav>
    </div>

    <section class="section">

        <div class="card shadow-lg border-0" style="border-radius:18px;">
            <div class="card-header bg-white p-4">
                <h4 class="mb-1 fw-bold">Base de Datos</h4>
                <p class="text-muted mb-0">
                    Estado: Rechazada • Puede editar y volver a subir archivos
                </p>
            </div>

            <div class="card-body p-4">

                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        <div class="col-md-6">

                            <div class="border rounded-4 p-4">
                                <h5 class="fw-bold text-primary mb-4">
                                    Documentos
                                </h5>

                                <div class="mb-3">
                                    <label>a) Instrumentación didáctica</label>
                                    <input
                                        type="file"
                                        name="doc_a"
                                        class="form-control"
                                        accept=".pdf">
                                </div>

                                <div class="mb-3">
                                    <label>b) Lista de calificaciones</label>
                                    <input
                                        type="file"
                                        name="doc_b"
                                        class="form-control"
                                        accept=".pdf">
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="border rounded-4 p-4">
                                <h5 class="fw-bold text-success mb-4">
                                    Evidencias
                                </h5>

                                <div class="mb-3">
                                    <label>a) Tareas complementarias</label>
                                    <input
                                        type="file"
                                        name="evi_a"
                                        class="form-control"
                                        accept=".pdf">
                                </div>

                                <div class="mb-3">
                                    <label>b) Rúbricas</label>
                                    <input
                                        type="file"
                                        name="evi_b"
                                        class="form-control"
                                        accept=".pdf">
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="text-center mt-4">
                        <button class="btn btn-warning px-5">
                            <i class="bi bi-save me-2"></i>
                            Guardar Cambios
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </section>

</main>
@endsection