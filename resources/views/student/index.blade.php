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
	@if (session('exitoAgregar'))
        <script>
            swal({
                title: "Invitado registrado",
                text: "{{ session('exitoAgregar') }}",
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
<body>
	<section class="vh-100" style="background-color: #0060B4;">
		<div class="container py-5 h-100">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col-12 col-md-8 col-lg-6 col-xl-5">
					<div class="card shadow-2-strong" style="border-radius: 1rem;">
						<div class="card-body p-5 text-center">
							<h3 class="mb-1">¡Bienvenido!</h3>
							<h3 class="mb-3">Sistema de Registro de Asistencia DAC</h3>
							<img class="img" width="125" src="http://127.0.0.1:8000/img/LOGO-DAC-20214.png" alt="LOGO DE DEPARTAMENTO DE ARTE Y CULTURA (DAC)">
                            <!-- Pills navs -->
							<ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
							<li class="nav-item" role="presentation">
								<a href="{{route('UDBStudentGuestSite.index') }}" class="nav-link" id="tab-register" data-mdb-toggle="pill" role="tab" aria-controls="pills-register" aria-selected="false" style="color: #0060B4;">Registrar Estudiante UDB</a>
							</li>
								<li class="nav-item" role="presentation">
									<a href="{{route('UDBStaffGuestSite.index')}}" class="nav-link" id="tab-register" data-mdb-toggle="pill"  role="tab" aria-controls="pills-register" aria-selected="false" style="color: #0060B4;">Registrar Personal UDB</a>
								</li>
							</ul>
                            <div class="row">
                                <a href="{{route('welcome')}}" class="btn btn-primary btn-lg btn-block mt-2" style="background-color: #0060B4;" type="submit">Regresar</a>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</section>
</body>

</html>