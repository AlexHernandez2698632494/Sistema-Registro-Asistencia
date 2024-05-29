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
                        <a href="{{ route('event.restoreView') }}"  id="eventosEliminados">Eventos eliminados</a>
                    </li>
                </ul>
            </li>  
            <li id="opcionesAdministradores">
                <a class="dropdown-toggle" data-bs-toggle="collapse" href="#menuAdministradores" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Administradores
                </a>
                <ul class="collapse list-unstyled" id="menuAdministradores">
                    <li>
                        <a href="{{ route('admin.create') }}" id="registroAdministradores">Registro de Administradores</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.index') }}" id="controlAdministradores">Control de Administradores</a>
                    </li>     
                    <li>
                        <a href="{{ route('admin.restoreView') }}" id="controlAdministradoresE">Administradores Eliminados</a>
                    </li>                
                </ul>
            </li>
            <li id="opcionesArea">
                <a class="dropdown-toggle" data-bs-toggle="collapse" href="#menuArea" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Areas
                </a>
                <ul class="collapse list-unstyled" id="menuArea">
                    <li>
                        <a href="{{ route('area.create') }}" id="registroAreas">Registro de Areas</a>
                    </li>
                    <li>
                        <a href="{{ route('area.index') }}" id="controlAreas">Control de Areas</a>
                    </li>     
                    <li>
                        <a href="{{ route('area.restoreView') }}" id="controlAreaE">Areas Eliminados</a>
                    </li>                   
                </ul>
            </li>
            <li id="opcionesVerRegistro">
                <a class="dropdown-toggle" data-bs-toggle="collapse" href="#menuRegistro" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Ver registro eventos
                </a>
                <ul class="collapse list-unstyled" id="menuRegistro">
                    <li><a href="#formativa">Area Formativa</a></li>
                    <li><a href="#entretenimiento">Area Entretenimiento</a></li>               
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
                </ul>
            </li>
            
            <li id="opcionesCambiarContra">
                <a href="{{route('users.formContra')}}">
                    Cambiar contraseña
                </a>
            </li>
                                                               
        </ul>
        <ul class="list-unstyled CTAs">
            {{-- <li>
                <a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Cerrar sesión</a>
            </li> --}}
            <li>
                <a href="{{ route('logout') }}" class="article">Cerrar sesión</a>

            </li>
        </ul>
    </nav>
   <!-- Page Content  -->
   {{-- <div id="content" class="mt-0 pt-0">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-align-left"></i>
                    <span>Toggle Sidebar</span>
                </button>
                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Page</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Page</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Page</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Page</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <h2>Collapsible Sidebar Using Bootstrap 4</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

    </div>
</div> --}}
