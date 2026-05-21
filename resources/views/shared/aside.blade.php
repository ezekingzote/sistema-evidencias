<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @if(auth()->user()->rol == 'admin')
        <li class="nav-heading">Panel Administrativo</li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fa-solid fa-chart-line"></i>
                <span>Dashboard Admin</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('semestres') }}">
                <i class="fa-solid fa-school-circle-check"></i>
                <span>Gestión de Semestres</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('docentes') }}">
                <i class="fa-solid fa-chalkboard-user"></i>
                <span>Control de Docentes</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('materias') }}">
                <i class="fa-solid fa-book-open"></i>
                <span>Catálogo de Materias</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('asignar-materias') }}">
                <i class="fa-solid fa-book-open-reader"></i>
                <span>Asignación Académica</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('revisiones') }}">
                <i class="fa-solid fa-person-chalkboard"></i>
                <span>Revisiones</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('seguimiento-academico') }}">
                <i class="fa-solid fa-person-walking-dashed-line-arrow-right"></i>
                <span>Seguimiento Academico</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('archivos') }}">
                <i class="fa-solid fa-folder-closed"></i>
                <span>Archivos</span>
            </a>
        </li>
        @endif


        @if(auth()->user()->rol == 'docente')
        <li class="nav-heading">Panel del Docente</li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-house-user"></i>
                <span>Mi Dashboard</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('mis-materias') }}">
                <i class="fa-solid fa-book-bookmark"></i>
                <span>Mis Materias</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('planes-estudio') }}">
                <i class="fa-solid fa-file-signature"></i>
                <span>Mis Planes de Estudio</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('evidencias') }}">
                <i class="fa-solid fa-receipt"></i>
                <span>Mis Evidencias</span>
            </a>
        </li>
        @endif

    </ul>

</aside>