    <nav id="sidebar">
        <div class="sidebar-header">
            <h4>Departamento de Arte y Cultura</h4>
        </div>
        <ul class="list-unstyled components">  
            <li id="opcionesEventos">
                <a class="dropdown-toggle" data-bs-toggle="collapse" href="#menuEventos" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Eventos
                </a>
                <ul class="collapse list-unstyled" id="menuDocentes">
                    
                            <li>
                                <a href=""> </a>
                            </li>
                                    
                </ul>
            </li>  
            <li id="opcionesMiPerfil">
                <a class="dropdown-toggle" data-bs-toggle="collapse" href="#menuAdministradores" role="button" aria-expanded="false" aria-controls="collapseExample">
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
            <div class="card" style="background-image: linear-gradient(to right,#025098 0%,#0152A1 25%, #015BA7 50%,#0B71B9 75%, #0D87C8 100%); color: white">
                <div class="card-body">
                    <b>Invitado</b><br>                                                           
                </div>
            </div>
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
