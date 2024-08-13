<div class="collapse navbar-collapse order-3 d-flex justify-content-center" id="navbarCollapse">
    <ul class="navbar-nav">
        <li class="nav-item" style="line-height: 11px;margin-top: 5px;">
            <p class="col-12 p-0 m-0" style="font-size: 13px;font-weight: normal;color: white;line-height: 12px; padding-bottom: 3px">Gestor</p>
            <p class="col-12 p-0 m-0" style="color: white;font-size: 15px;font-weight: 900">Horarios</p>
        </li>
        <li class="nav-item">
            <a href="{{ url('main/dashboard') }}" class="nav-link">Inicio</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" aria-current="page" data-bs-toggle="dropdown" aria-expanded="false">
                Gestionar
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url("main/cargarAreas")}}">Areas</a></li>
                <li><a class="dropdown-item" href="{{url("main/cargargrupos")}}">Grupo Horarios</a></li>
                <li><a class="dropdown-item" href="{{url("main/cargarusuarios")}}">Usuarios</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" aria-current="page" data-bs-toggle="dropdown" aria-expanded="false">
                Informes
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url("main/informes")}}">Seguimiento de Horarios</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{ url('logout') }}" class="nav-link">Cerrar Sesión</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">{{session('nombre_usuario')}}</a>
        </li>
    </ul>
</div>
