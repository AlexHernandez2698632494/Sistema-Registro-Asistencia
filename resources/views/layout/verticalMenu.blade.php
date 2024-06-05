<nav id="sidebar">
    <div class="sidebar-header">
        <h4>Departamento de Arte y Cultura</h4>
    </div>
    <ul class="list-unstyled components">
        <li id="opcionesEventos">
            <a class="dropdown-toggle" data-bs-toggle="collapse" href="#menuEventos" role="button" aria-expanded="false" aria-controls="collapseExample">
                Eventos
            </a>
            <ul class="collapse list-unstyled" id="menuEventos">
                <li>
                    <a href="{{route('events.create')}}" id="registroEventos">Registro de eventos</a>
                </li>
                <li>
                    <a href="{{route('events.index')}}" id="controlEventos">Control de eventos</a>
                </li>
                <li>
                    <a href="{{ route('event.restoreView') }}" id="eventosEliminados">Eventos eliminados</a>
                </li>
            </ul>
        </li>
        <li id="opcionesAdministradores">
            <a class="dropdown-toggle" data-bs-toggle="collapse" href="#menuAdministradores" role="button" aria-expanded="false" aria-controls="collapseExample">
                Administradores
            </a>
            <ul class="collapse list-unstyled" id="menuAdministradores">
                <li>
                    <a href="{{ route('admin.create') }}" id="registroAdministradores">Registro de administradores</a>
                </li>
                <li>
                    <a href="{{ route('admin.index') }}" id="controlAdministradores">Control de administradores</a>
                </li>
                <li>
                    <a href="{{ route('admin.restoreView') }}" id="controlAdministradoresE">Administradores eliminados</a>
                </li>
            </ul>
        </li>
        <li id="opcionesArea">
            <a class="dropdown-toggle" data-bs-toggle="collapse" href="#menuArea" role="button" aria-expanded="false" aria-controls="collapseExample">
                Áreas
            </a>
            <ul class="collapse list-unstyled" id="menuArea">
                <li>
                    <a href="{{ route('area.create') }}" id="registroAreas">Registro de áreas</a>
                </li>
                <li>
                    <a href="{{ route('area.index') }}" id="controlAreas">Control de áreas</a>
                </li>
                <li>
                    <a href="{{ route('area.restoreView') }}" id="controlAreaE">Áreas eliminadas</a>
                </li>
            </ul>
        </li>
        <li id="opcionesVerRegistro">
            <a class="dropdown-toggle" data-bs-toggle="collapse" href="#menuRegistro" role="button" aria-expanded="false" aria-controls="collapseExample">
                Ver registros eventos
            </a>
            <ul class="collapse list-unstyled" id="menuRegistro">
                <li><a href="{{route('viewEventLog.viewAttendanceRecordUDB')}}">Registro de asistencia UDB</a></li>
                <li><a href="{{route('viewEventLog.viewAttendanceRecordEntertainmentArea')}}">Registro de asistencia</a></li>
            </ul>
        </li>
        <li id="opcionesUsuarios">
            <a class="dropdown-toggle" data-bs-toggle="collapse" href="#menuUsuarios" role="button" aria-expanded="false" aria-controls="collapseExample">
                Usuarios
            </a>
            <ul class="collapse list-unstyled" id="menuUsuarios">
                <li>
                    <a href="{{route('user.index')}}" id="controlUsuarios">Control de usuarios</a>
                </li>
                <li>
                    <a href="{{route('user.site')}}" id="propaganda">Propaganda</a>
                </li>
            </ul>
        </li>
        <li id="opcionesCambiarContra">
            <a href="{{route('users.formContra')}}">
                Cambiar contraseña
            </a>
        </li>
    </ul>
    <ul class="list-unstyled CTAs">
        <li>
            <a href="{{ route('logout') }}" class="article">Cerrar sesión</a>
        </li>
    </ul>
</nav>

