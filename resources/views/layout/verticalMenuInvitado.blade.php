    <nav id="sidebar">
        <div class="sidebar-header">
            <h4>Departamento de Arte y Cultura</h4>
        </div>
        <ul class="list-unstyled components">  
            <li id="opcionesEventos">
                <a href="{{route('guestSite.site')}}">
                    Eventos
                </a>
            </li>  
            <li id="opcionesEntradas">
                <a href="{{route('guestSite.purchasedTicket')}}">
                    Entradas Adquiridas
                </a>
            </li>  
            <li id="opcionesMiPerfil">
                <a href="{{route('guestSite.miPerfil')}}">
                    Mi perfil
                </a>
            </li>
            
            <li id="opcionesCambiarContra">
                <a href="{{route('users.formContra')}}">
                    Cambiar contraseña
                </a>
            </li>  
            <li id="opcionesMostrarManual">
                <a target="_blank" href="{{asset('/pdf/manualInvitado.pdf')}}">
                    Manual de usuario
                </a>
            </li>                                                          
        </ul>

        <ul class="list-unstyled CTAs">
        <li class="my-1">
            <div class="card" style="background-image: linear-gradient(to right,#025098 0%,#0152A1 25%, #015BA7 50%,#0B71B9 75%, #0D87C8 100%); color: white">
                <div class="card-body">
                    <b>Invitado</b><br> 
                    @if (session()->has('invitado'))
                            {{ session()->get('invitado')[0]->nombreInvitado.' '.session()->get('invitado')[0]->apellidosInvitado }}
                        @endif                                                            
                </div>
            </div>
        </li>
        </ul>
        <ul class="list-unstyled CTAs">
            <li>
                <a href="{{ route('logout') }}" class="article">Cerrar sesión</a>
            </li>
        </ul>
    </nav>
   