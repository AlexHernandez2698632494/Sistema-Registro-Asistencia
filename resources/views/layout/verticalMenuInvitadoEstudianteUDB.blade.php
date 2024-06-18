    <nav id="sidebar">
        <div class="sidebar-header">
            <h4>Departamento de Arte y Cultura</h4>
        </div>
        <ul class="list-unstyled components">  
            <li id="opcionesEventos">
                <a href="{{route('UDBStudentGuestSite.site')}}">
                    Eventos
                </a>
            </li>  
            <li id="opcionesEntradas">
                <a href="{{route('UDBStudentGuestSite.purchasedTicket')}}">
                    Entradas Adquiridas
                </a>
            </li> 
            <li id="opcionesMiPerfil">
                <a href="{{route('UDBStudentGuestSite.miPerfil')}}">
                    Mi perfil
                </a>
            </li>
            
            <li id="opcionesCambiarContra">
                <a href="{{route('users.formContra')}}">
                    Cambiar contraseña
                </a>
            </li>   
            <li id="opcionesMostrarManual">
                <a target="_blank" href="{{asset('/pdf/manualEstudianteUDB.pdf')}}">
                    Manual de usuario
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