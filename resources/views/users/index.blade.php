@extends('layout.header')
 
 
@section('title','Control de usuarios')
 
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/users/indexInit.js') }}"></script>
<body style="overflow-x: hidden">    
    <script src="{{ asset('js/inactividad.js') }}"></script>
    @if (session('exitoEliminar'))
        <script>
            swal({
                title: "Registro eliminado",
                text: "{{ session('exitoEliminar') }}",
                icon: "success",
                button: "OK",
            })            
        </script>
    @endif
 
    @if (session('errorEliminar'))
        <script>
            swal({
                title: "Error al eliminar",
                text: "{{ session('errorEliminar') }}",
                icon: "error",
                button: "OK",
            })            
        </script>
    @endif
 
    @include('layout.horizontalMenu')    
    <div class="wrapper">
        @include('layout.verticalMenu')
        <div id="content" class="mt-0 pt-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 mx-5">
                <div class="container-fluid">                    
                    <div class="col d-flex justify-content-center">
                        <p style="color: black; margin: 0; font-weight: bold">Control de usuarios</p>
                    </div>                                          
                </div>
            </nav>                                      
            <div class="card card-Teachers mx-5">
                <div class="card-body cardBody-Teachers">
                    <p class="d-flex justify-content-center">Usuarios registrados</p>
                    <div class="separator mb-3"></div>                                          
                        <table class="table data-table table-striped" id="teachers-table">
                            <thead class="table-head">
                                <tr>
                                    <th scope="col">Tipo de Usuario</th>
                                    <th scope="col">Nombre de Usuario</th>
                                    <th scope="col">Nombre</th>
                                </tr>
                            </thead>
                            <div class="table-body">
                                <tbody>
                                    @foreach ($estudiantesUDB as $estudianteUDB)
                                        <tr>
                                            <td>Estudiante</td>
                                            <td>{{$estudianteUDB->usuario}}</td>
                                            <td>{{ $estudianteUDB->nombreUDB.' '.$estudianteUDB->apellidosUDB }}</td>
                                        </tr>
                                    @endforeach
                                    @foreach ($invitados as $invitado)
                                        <tr>
                                            <td>Invitado</td>
                                            <td>{{$invitado->usuario}}</td>
                                            <td>{{ $invitado->nombreInvitado.' '.$invitado->apellidosInvitado }}</td>
                                        </tr>
                                    @endforeach
                                    @foreach ($administradores as $administrador)
                                        <tr>
                                            <td>Administrador</td>
                                            <td>{{$administrador->usuario}}</td>
                                            <td>{{ $administrador->nombreAdmin.' '.$administrador->apellidosAdmin }}</td>
                                        </tr>
                                    @endforeach
                                    @foreach ($estudiantesOtra as $estudianteOtra)
                                        <tr>
                                            <td>Invitados Institución</td>
                                            <td>{{$estudianteOtra->usuario}}</td>
                                            <td>{{ $estudianteOtra->nombreInstitucion.' '.$estudianteOtra->apellidosInstitucion }}</td>
                                        </tr>
                                    @endforeach                                                                                                                                                              
                                </tbody>
                            </div>
                        </table>                                                                
                    </div>
                </div>
            </div>                                            
        </div>
    <!-- Modal para eliminar usuario-->
    <div class="modal fade" id="eliminarUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <div class="row mt-2">
                            <div class="col-lg-12 col-xs-12">
                                <label id="txtPregunta" name="txtPregunta" class="form-label" style="font-weight: bold"></label>
                            </div>
                        </div>
                        <div class="row mt-2">  
                            <input type="text" id="txtIdUsuarioEliminar" name="idUsuarioEliminar" hidden>
                        </div>
                    </div>
                    <div class="modal-footer">                        
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger" style="color: white">Eliminar</button>                      
                    </div>
                </form>
            </div>
        </div>
    </div>
   
</body>
</html>