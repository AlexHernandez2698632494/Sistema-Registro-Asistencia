@extends('layout.header')

@section('title','Login')
    
<script src="{{ asset('js/sweetalert.js') }}"></script>
{{-- #7facff --}}
<body>
	@if (session('errorLogin'))
        <script>
            swal({
                title: "Información incorrecta",
                text: "{{ session('errorLogin') }}",
                icon: "error",
                button: "OK",
            })            
        </script>
    @endif
	@if (session('exitoRegistoAdmin'))
        <script>
            swal({
                title: "Administrador registrado",
                text: "{{ session('exitoRegistoAdmin') }}",
                icon: "success",
                button: "OK",
            })            
        </script>
    @endif
	@if (session('exitoSolicitud'))
        <script>
            swal({
                title: "Solicitud realizada",
                text: "{{ session('exitoSolicitud') }}",
                icon: "success",
                button: "OK",
            })            
        </script>
    @endif
   <section class="vh-200" style="background-color: #0060B4;">
		<div class="container py-5 h-200">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col-12 col-md-8 col-lg-6 col-xl-5">
					<div class="card shadow-2-strong" style="border-radius: 1rem;">
						<div class="card-body p-5 text-center">			
							<h3 class="mb-1">¡Bienvenido!</h3>
							<h3 class="mb-3">Sistema de Registro de Asistencia DAC</h3>
							<img class="img" width="125" src="http://127.0.0.1:8000/img/LOGO-DAC-2021.png" alt="">
															
							<div class="my-4" style="background-color:#0060B4; height: 3px; border-radius: 2rem"></div>
								@if ($errors->any())
									<div class="alert alert-danger my-2 pb-0">
										<ul>
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
								@if(session('error'))
									<div class="alert alert-danger">
										{{ session('error') }}
									</div>
								@endif
								<form method="POST" action="{{ route('login') }}">
									@csrf
									<div class="input-group mb-3">
										<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
										<input type="text" class="form-control" placeholder="Usuario" aria-label="user" name="user">
									</div>
									<div class="input-group mb-3">
										<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
										<input type="password" class="form-control" placeholder="Contraseña" aria-label="password" name="password">
									</div>	
									<div class="row">
										<button class="btn btn-primary btn-lg btn-block mt-2" type="submit">Ingresar</button>
									</div>	
									<div class="row">
										<p class="mt-3"><a href="{{ route('recuperarView') }}" class="link-underline-primary">Olvidé mi contraseña</a></p>
									</div>											
								</form>		
							</div>										
						</div>
					</div>
				</div>
			</div>
		</div>
   </section>    
</body>
</html>
