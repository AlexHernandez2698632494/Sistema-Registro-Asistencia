@extends('layout.header')


@section('title','Cambiar contraseña')

<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/users/cambiarContra.js') }}"></script>
<body style="overflow-x: hidden">    
	<script src="{{ asset('js/inactividad.js') }}"></script>
	@if (session('exitoCambiar'))
        <script>
            swal({
                title: "Contraseña cambiada",
                text: "{{ session('exitoCambiar') }}",
                icon: "success",
                button: "OK",
            })            
        </script>
    @endif

    @if (session('errorCambiar'))
        <script>
            swal({
                title: "Error al cambiar contraseña",
                text: "{{ session('errorCambiar') }}",
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
                    <a href="{{ route('events.index') }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regresar">
                        <i class="fas fa-arrow-left"></i>
                    </a>                    
                    <div class="col text-center">
                        <p style="color: black; margin: 0; font-weight: bold">Cambiar contraseña</p>
                    </div>
                </div>
            </nav>                        				
			<div class="card mx-5">
				<div class="card-body cardBody-Teachers">
                    <form method="POST" action="{{ route('user.cambiarContra') }}">
                        @csrf
                        @method('PUT')
                        <div class="col-lg-3 col-xs-12 mt-2" hidden>
                            <label for="txtPasswordAdministrador" class="form-label">Contraseña</label>                                
                            <input type="password" id="txtPasswordAdministrador" name="passwordAdministrador" placeholder="Ingrese contraseña" class="form-control inputTxt">
                        </div>	
                        <div class="row justify-content-center">
                            <div class="col-lg-3 col-xs-12 mt-2">
                                <label for="txtPasswordActual" class="form-label">Contraseña Actual</label>                                
                                <input type="password" id="txtPasswordActual" name="passwordActual" placeholder="Ingrese contraseña actual" class="form-control inputTxt" required>
                            </div>	
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-3 col-xs-12 mt-2">
                                <label for="txtPasswordNueva" class="form-label">Contraseña Nueva</label>                                
                                <input type="password" id="txtPasswordNueva" name="passwordNueva" placeholder="Ingrese contraseña nueva" class="form-control inputTxt" required>
                            </div>	
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-3 col-xs-12 mt-2">
                                <label for="txtPasswordConfirmar" class="form-label">Confirmar Contraseña Nueva</label>                                
                                <input type="password" id="txtPasswordConfirmar" name="passwordConfirmar" placeholder="Confirme contraseña nueva" class="form-control inputTxt" required>
                            </div>	
                        </div>
                        @csrf
                        @method('PUT')
                        <div class="row justify-content-center">
                            <div class="col-lg-2 col-xs-12 mt-2">
                                
                                <button class="btn btn-primary mt-2" style="background-image: linear-gradient(to right,#025098 0%,
                                #0152A1 25%,
                                #015BA7 50%,
                                #0B71B9 75%,
                                #0D87C8 100%)" type="submit">Cambiar contraseña</button>                            </div>
                        </div>		
                    </form>																	
					</div>
				</div>
			</div>									           
        </div>
    
</body>
</html>