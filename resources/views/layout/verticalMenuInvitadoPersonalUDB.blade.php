    <nav id="sidebar">
        <div class="sidebar-header">
            <h4>Departamento de Arte y Cultura</h4>
        </div>
        <ul class="list-unstyled components">  
            <li id="opcionesEventos">
                <a href="{{route('UDBStaffGuestSite.site')}}">
                    Eventos
                </a>
            </li>  
            <li id="opcionesEntradas">
                <a href="{{route('UDBStaffGuestSite.purchasedTicket')}}">
                    Entradas Adquiridas
                </a>
            </li>
            <li id="opcionesMiPerfil">
                <a href="{{route('UDBStaffGuestSite.miPerfil')}}">
                    Mi perfil
                </a>
            </li>
            
            <li id="opcionesCambiarContra">
                <a href="{{route('users.formContra')}}">
                    Cambiar contraseña
                </a>
            </li>                                                        
        </ul>

        <ul class="list-unstyled CTAs">
        <li class="my-1">
            <div class="card-body">
                
                @if (session()->has('personalUDB'))
                        {{ session()->get('personalUDB')[0]->nombreUDB.' '.session()->get('personalUDB')[0]->apellidosUDB.' '.session()->get('personalUDB')[0]->carnetUDB }}
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