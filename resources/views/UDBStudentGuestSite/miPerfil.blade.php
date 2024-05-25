@extends('layout.header')


@section('title','Mi Perfil')

<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/guestSite/miPerfil.js') }}"></script>

<body style="overflow-x: hidden">    
	<script src="{{ asset('js/inactividad.js') }}"></script>
	@if (session('exitoModificar'))
        <script>
            swal({
                title: "Registro modificado",
                text: "{{ session('exitoModificar') }}",
                icon: "success",
                button: "OK",
                closeOnClickOutside: false,
                }).then((value) => {
                if (value) {
                    location.reload(); 
                }
            })            
        </script>
    @endif

    @if (session('errorModificar'))
        <script>
            swal({
                title: "Error al modificar",
                text: "{{ session('errorModificar') }}",
                icon: "error",
                button: "OK",
                closeOnClickOutside: false,
                }).then((value) => {
                if (value) {
                    location.reload(); 
                }
            })            
        </script>
    @endif    

    @include('layout.horizontalMenu')    
    <div class="wrapper">
        @include('layout.verticalMenuInvitadoEstudianteUDB')
        <div id="content" class="mt-0 pt-0">            
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 mx-5">
                <div class="container-fluid">                    
                    <a href="{{ route('guestSite.index') }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regresar">
                        <i class="fas fa-arrow-left"></i>
                    </a>                    
                    <div class="col text-center">
                        <p style="color: black; margin: 0; font-weight: bold">Mi Perfil</p>
                    </div>
                </div>
            </nav>    
            <div class="card mx-5">
				<div class="card-body cardBody-Teachers">
                    <p class="d-flex justify-content-center">Información general</p>
					<div class="separator mb-3"></div>	
                    @if ($errors->any())
						<div class="alert alert-danger my-2 pb-0">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
                    <div class="row mx-1">
                         <div class="col-lg-6 col-xs-12">
                            <p style="margin-bottom: 0; font-weight: bold" class="mt-2">Nombre</p>
                            {{ $informacionUDB[0]->nombreUDB.' '.$informacionUDB[0]->apellidosUDB}}
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <p style="margin-bottom: 0; font-weight: bold" class="mt-2">Carnet</p>
                            {{$informacionUDB[0]->carnetUDB}}
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <p style="margin-bottom: 0; font-weight: bold" class="mt-2">Teléfono</p>
                            {{$informacionUDB[0]->telefonoUDB}}
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <p style="margin-bottom: 0; font-weight: bold" class="mt-2">Correo electrónico</p>
                            {{$informacionUDB[0]->correoUDB}}
                        </div>                                                                
                    </div>  
                    <div class="separator mb-3 mt-3"></div>                 	       
                    <div class="row mx-1 mt-3 d-flex justify-content-center">                        
                        <div class="col-lg-4">
                            <div class="btn-group d-flex justify-content-center">
                                <a type="button" onclick="updateInformacionModal({{$informacionUDB[0]->idUDB}})" class="btn btn-primary mt-2 btn-block" style="background-color: #2F98FE;">Actualizar información</a>
                            </div>
                        </div>                       
                    </div>         																												
				</div>
			</div>                 							
        </div>
    </div>	

    <!-- Modal para actualizar información-->
     <div class="modal fade" id="modificarInformacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Actualización de información</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('UDBStudentGuestSite.updateInfor') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row mt-2">
                            <div class="col-lg-6 col-xs-12">
                                <label for="txtCorreoInvitado" class="form-label" style="font-weight: bold">Correo del invitado</label>                                
                                <input type="email" id="txtCorreoInvitado" name="correoInvitado" placeholder="Ingrese correo electrónico del invitado" class="form-control inputTxt" value="{{$informacionUDB[0]->correoUDB}}">
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <label for="txtTelefonoInvitado" class="form-label" style="font-weight: bold">Teléfono del invitado</label>                                
                                <input type="text" id="txtTelefonoInvitado" name="telefonoInvitado" placeholder="Ingrese teléfono del invitado" class="form-control inputTxt" value="{{$informacionUDB[0]->telefonoUDB}}">
                            </div>    
                            <input type="text" id="txtIdInvitado" name="idInvitadoActualizar" value="{{$informacionUDB[0]->idUDB}}" hidden>                    
                        </div>
                    </div>
                    <div class="modal-footer">                        
                            @csrf
                            @method('PUT')                           
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-warning" style="color: white">Actualizar</button>                       
                    </div>
                </form>
            </div>
        </div>
    </div>  
    
</body>
</html>