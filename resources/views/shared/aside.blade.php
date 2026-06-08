<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        
        {{-- Determinamos qué panel está activo en la sesión --}}
        @php 
            $panel = session('panel_activo', Auth::user()->rol == 'admin' ? 'admin' : 'docente'); 
        @endphp

        {{-- PANEL ADMINISTRATIVO --}}
        @if($panel == 'admin' && auth()->user()->rol == 'admin')
            <li class="nav-heading">Panel Administrativo</li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('home') ? '' : 'collapsed' }}" href="{{ route('home') }}">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Dashboard Admin</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('semestres*') || request()->routeIs('semestre.*') ? '' : 'collapsed' }}" href="{{ route('semestres') }}">
                    <i class="fa-solid fa-school-circle-check"></i>
                    <span>Gestión de Semestres</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('docentes*') || request()->routeIs('nuevo-docente') || request()->routeIs('pdf.descargar') ? '' : 'collapsed' }}" href="{{ route('docentes') }}">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    <span>Control de Docentes</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('materias*') || request()->routeIs('nueva-materia') ? '' : 'collapsed' }}" href="{{ route('materias') }}">
                    <i class="fa-solid fa-book-open"></i>
                    <span>Catálogo de Materias</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('asignar-materias*') ? '' : 'collapsed' }}" href="{{ route('asignar-materias') }}">
                    <i class="fa-solid fa-book-open-reader"></i>
                    <span>Asignación Académica</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('revisiones*') ? '' : 'collapsed' }}" href="{{ route('revisiones') }}">
                    <i class="fa-solid fa-person-chalkboard"></i>
                    <span>Revisiones</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('seguimiento-academico*') ? '' : 'collapsed' }}" href="{{ route('seguimiento-academico') }}">
                    <i class="fa-solid fa-person-walking-dashed-line-arrow-right"></i>
                    <span>Seguimiento Académico</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('reportes*') || request()->routeIs('reportes-generar') || request()->routeIs('reportes-vacio') ? '' : 'collapsed' }}" href="{{ route('reportes') }}">
                    <i class="fa-solid fa-laptop-file"></i>
                    <span>Reportes de Seguimiento Académico</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('archivos*') || request()->routeIs('carpetas.*') ? '' : 'collapsed' }}" href="{{ route('archivos') }}">
                    <i class="fa-solid fa-folder-closed"></i>
                    <span>Archivos</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('imagenes*') ? '' : 'collapsed' }}" href="{{ route('imagenes') }}">
                    <i class="fa-solid fa-file-image"></i>
                    <span>Imágenes de Oficios</span>
                </a>
            </li>
        @endif

        {{-- PANEL DOCENTE --}}
        @if($panel == 'docente' && auth()->user()->docente)
            <li class="nav-heading">Panel del Docente</li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-house-user"></i>
                    <span>Mi Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('mis-materias*') ? '' : 'collapsed' }}" href="{{ route('mis-materias') }}">
                    <i class="fa-solid fa-book-bookmark"></i>
                    <span>Mis Materias</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('planes-estudio*') || request()->routeIs('agregar-plan-estudio') || request()->routeIs('editar-plan-estudio') || request()->routeIs('ver-plan-estudio') ? '' : 'collapsed' }}" href="{{ route('planes-estudio') }}">
                    <i class="fa-solid fa-file-signature"></i>
                    <span>Mis Planes de Estudio</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('evidencias*') || request()->routeIs('evaluaciones.*') ? '' : 'collapsed' }}" href="{{ route('evidencias') }}">
                    <i class="fa-solid fa-receipt"></i>
                    <span>Mis Evidencias</span>
                </a>
            </li>
        @endif

    </ul>
</aside>