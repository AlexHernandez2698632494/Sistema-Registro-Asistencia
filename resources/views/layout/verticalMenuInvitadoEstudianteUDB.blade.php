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
                        <a href="" id="registroDocentes">Registro de eventos</a>
                    </li>
                    <li>
                        <a href="" id="controlDocentes">Control de eventos</a>
                    </li>
                    <li>
                        <a href="" id="docentesEliminados">Eventos eliminados</a>
                    </li>
                </ul>
            </li>  
            <li id="opcionesMiPerfil">
                <a href="{{route('UDBStudentGuestSite.miPerfil')}}">
                    Mi perfil
                </a>
            </li>
            
            <li id="opcionesCambiarContra">
                <a href="">
                    Cambiar contraseña
                </a>
            </li>                                                        
        </ul>

        <ul class="list-unstyled CTAs">
        <li class="my-1">
            <div class="card-body">
                <b>Estudiantes</b><br> 
                @if (session()->has('estudianteUDB'))
                        {{ session()->get('estudianteUDB')[0]->nombreUDB.' '.session()->get('estudianteUDB')[0]->apellidosUDB.' '.session()->get('estudianteUDB')[0]->carnetUDB }}
                    @endif                                                            
            </div>
        </li>
        </ul>
        <ul class="list-unstyled CTAs">
            <li>
                <a href="{{ route('logout') }}" class="article">Cerrar sesión</a>
            </li>
        </ul>
    </nav>