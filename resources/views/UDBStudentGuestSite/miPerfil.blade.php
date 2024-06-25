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
                    <a href="{{ route('UDBStudentGuestSite.site') }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regresar">
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
                            <p style="margin-bottom: 0; font-weight: bold" class="mt-2">Carrera</p>
                            {{$informacionUDB[0]->carreraUDB}}
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <p style="margin-bottom: 0; font-weight: bold" class="mt-2">Teléfono</p>
                            {{$informacionUDB[0]->telefonoUDB}}
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <p style="margin-bottom: 0; font-weight: bold" class="mt-2">Correo electrónico</p>
                            {{$informacionUDB[0]->correoUDB}}
                        </div>     
                        <div class="col-lg-6 col-xs-12">
                            <p style="margin-bottom: 0; font-weight: bold" class="mt-2">Estado</p>
                            {{$informacionUDB[0]->estadoUDB}}
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
                                <label for="txtCorreoInvitado" class="form-label" style="font-weight: bold">Correo</label>                                
                                <input type="email" id="txtCorreoInvitado" name="correoUDB" placeholder="Ingrese correo electrónico del invitado" class="form-control inputTxt" value="{{$informacionUDB[0]->correoUDB}}">
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <label for="txtTelefonoInvitado" class="form-label" style="font-weight: bold">Teléfono</label>                                
                                <input type="text" id="txtTelefonoInvitado" name="telefonoUDB" placeholder="Ingrese teléfono del invitado" class="form-control inputTxt" value="{{$informacionUDB[0]->telefonoUDB}}">
                            </div>   
                            <div class="col-lg-6 col-xs-12">
                                <label for="txtTelefonoInvitado" class="form-label" style="font-weight: bold">Estado</label>                                
                                <select class="form-select" id="sexo" name="estadoUDB" value="{{$informacionUDB[0]->estadoUDB}}" required>
                                <option value="Activo" {{ $informacionUDB[0]->estadoUDB == 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="No Activo" {{ $informacionUDB[0]->estadoUDB == 'no Activo' ? 'selected' : '' }}>No Activo</option>
                                <option value="Graduado" {{ $informacionUDB[0]->estadoUDB == 'Graduado' ? 'selected' : '' }}>Graduado</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-xs-12">
                            <label for="txtTelefonoInvitado" class="form-label" style="font-weight: bold">Carrera</label>                                
                                <select class="form-select" id="sexo" name="carreraUDB" value="{{$informacionUDB[0]->carreraUDB}}" required>
                                <optgroup label="Ingenierías">
                                <option value="Ingeniería Mecanica"{{ $informacionUDB[0]->carreraUDB == 'Ingeniería Mecanica' ? 'selected' : '' }} >Ingeniería Mecanica</option>
                                <option value="Ingeniería Industrial"{{ $informacionUDB[0]->carreraUDB == 'Ingeniería Industrial' ? 'selected' : '' }}>Ingeniería Industrial</option>
                                <option value="Ingeniería Biomédica"{{ $informacionUDB[0]->carreraUDB == 'Ingeniería Biomédica' ? 'selected' : '' }}>Ingeniería Biomédica</option>
                                <option value="Ingeniería en Ciencias de la Computación"{{ $informacionUDB[0]->carreraUDB == 'Ingeniería en Ciencias de la Computación' ? 'selected' : '' }}>Ingeniería en Ciencias de la Computación</option>
                                <option value="Ingeniería Eléctrica"{{ $informacionUDB[0]->carreraUDB == 'Ingeniería Eléctrica' ? 'selected' : '' }}>Ingeniería Eléctrica</option>
                                                    <option value="Ingeniería Mecatrónica"{{ $informacionUDB[0]->carreraUDB == 'Ingeniería Mecatrónica' ? 'selected' : '' }}>Ingeniería Mecatrónica</option>
                                                    <option value="Ingeniería en Aeronáutica"{{ $informacionUDB[0]->carreraUDB == 'Ingeniería en Aeronáutica' ? 'selected' : '' }}>Ingeniería en Aeronáutica</option>
                                                    <option value="Ingeniería Electrónica y Automatización"{{ $informacionUDB[0]->carreraUDB == 'Ingeniería Electrónica y Automatización' ? 'selected' : '' }}>Ingeniería Electrónica y Automatización</option>
                                                    <option value="Ingeniería en Telecomunicaciones y Redes"{{ $informacionUDB[0]->carreraUDB == 'Ingeniería en Telecomunicaciones y Redes' ? 'selected' : '' }}>Ingeniería en Telecomunicaciones y Redes</option>
                                                    <option value="Ingeniería Industrial (Campus Antiguo Cuscatlán)"{{ $informacionUDB[0]->carreraUDB == 'Ingeniería Industrial (Campus Antiguo Cuscatlán)' ? 'selected' : '' }}>Ingeniería Industrial (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Ingeniería en Ciencias de la Computación (Campus Antiguo Cuscatlán)"{{ $informacionUDB[0]->carreraUDB == 'Ingeniería en Ciencias de la Computación (Campus Antiguo Cuscatlán)' ? 'selected' : '' }}>Ingeniería en Ciencias de la Computación (Campus Antiguo Cuscatlán)</option>
                                                </optgroup>
                                                <optgroup label="Licenciaturas">
                                                    <option value="Licenciatura en Teología Pastoral"{{ $informacionUDB[0]->carreraUDB == 'Licenciatura en Teología Pastoral' ? 'selected' : '' }}>Licenciatura en Teología Pastoral</option>
                                                    <option value="Licenciatura en Idiomas con Especialidad en la Adquisición de Lenguas Extranjeras"{{ $informacionUDB[0]->carreraUDB == 'Licenciatura en Idiomas con Especialidad en la Adquisición de Lenguas Extranjeras' ? 'selected' : '' }}>Licenciatura en Idiomas con Especialidad en la Adquisición de Lenguas Extranjeras</option>
                                                    <option value="Licenciatura en Idiomas con Especialidad en Turismo"{{ $informacionUDB[0]->carreraUDB == 'Licenciatura en Idiomas con Especialidad en Turismo' ? 'selected' : '' }}>Licenciatura en Idiomas con Especialidad en Turismo</option>
                                                    <option value="Licenciatura en Ciencias de la Comunicación"{{ $informacionUDB[0]->carreraUDB == 'Licenciatura en Ciencias de la Comunicación' ? 'selected' : '' }}>Licenciatura en Ciencias de la Comunicación</option>
                                                    <option value="Licenciatura en Diseño Gráfico"{{ $informacionUDB[0]->carreraUDB == 'Licenciatura en Diseño Gráfico' ? 'selected' : '' }}>Licenciatura en Diseño Gráfico</option>
                                                    <option value="Licenciatura en Diseño Industrial"{{ $informacionUDB[0]->carreraUDB == 'Licenciatura en Diseño Industrial' ? 'selected' : '' }}>Licenciatura en Diseño Industrial</option>
                                                    <option value="Licenciatura en Marketing"{{ $informacionUDB[0]->carreraUDB == 'Licenciatura en Marketing' ? 'selected' : '' }}>Licenciatura en Marketing</option>
                                                    <option value="Licenciatura en Contaduría Pública"{{ $informacionUDB[0]->carreraUDB == 'Licenciatura en Contaduría Pública"' ? 'selected' : '' }}>Licenciatura en Contaduría Pública</option>
                                                    <option value="Licenciatura en Administración de Empresas"{{ $informacionUDB[0]->carreraUDB == 'Licenciatura en Administración de Empresas' ? 'selected' : '' }}>Licenciatura en Administración de Empresas</option>
                                                    <option value="Licenciatura en Marketing (Campus Antiguo Cuscatlán)"{{ $informacionUDB[0]->carreraUDB == 'Licenciatura en Marketing (Campus Antiguo Cuscatlán)' ? 'selected' : '' }}>Licenciatura en Marketing (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Licenciatura en Idiomas Turismo (Campus Antiguo Cuscatlán)"{{ $informacionUDB[0]->carreraUDB == 'Licenciatura en Idiomas Turismo (Campus Antiguo Cuscatlán)' ? 'selected' : '' }}>Licenciatura en Idiomas Turismo (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Licenciatura en Diseño Gráfico (Campus Antiguo Cuscatlán)"{{ $informacionUDB[0]->carreraUDB == 'Licenciatura en Diseño Gráfico (Campus Antiguo Cuscatlán)' ? 'selected' : '' }}>Licenciatura en Diseño Gráfico (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Licenciatura en Ciencias de la Comunicación (Campus Antiguo Cuscatlán)"{{ $informacionUDB[0]->carreraUDB == 'Licenciatura en Ciencias de la Comunicación (Campus Antiguo Cuscatlán)' ? 'selected' : '' }}>Licenciatura en Ciencias de la Comunicación (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Licenciatura en Administración de Empresas (Campus Antiguo Cuscatlán)"{{ $informacionUDB[0]->carreraUDB == 'Licenciatura en Administración de Empresas (Campus Antiguo Cuscatlán)' ? 'selected' : '' }}>Licenciatura en Administración de Empresas (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Licenciatura en Idiomas con Especialidad en la Adquisición de Lenguas Extranjeras (Campus Antiguo Cuscatlán)"{{ $informacionUDB[0]->carreraUDB == 'Licenciatura en Idiomas con Especialidad en la Adquisición de Lenguas Extranjeras (Campus Antiguo Cuscatlán)' ? 'selected' : '' }}>Licenciatura en Idiomas con Especialidad en la Adquisición de Lenguas Extranjeras (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Licenciatura en Contaduría Pública (Campus Antiguo Cuscatlán)"{{ $informacionUDB[0]->carreraUDB == 'Licenciatura en Contaduría Pública (Campus Antiguo Cuscatlán)' ? 'selected' : '' }}>Licenciatura en Contaduría Pública (Campus Antiguo Cuscatlán)</option>
                                                </optgroup>
                                                <optgroup label="Técnicos">
                                                    <option value="Técnico en Ingeniería Mecánica"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Ingeniería Mecánica' ? 'selected' : '' }}>Técnico en Ingeniería Mecánica</option>
                                                    <option value="Técnico en Ingeniería Eléctrica"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Ingeniería Eléctrica' ? 'selected' : '' }}>Técnico en Ingeniería Eléctrica</option>
                                                    <option value="Técnico en Ingeniería Electrónica"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Ingeniería Electrónica' ? 'selected' : '' }}>Técnico en Ingeniería Electrónica</option>
                                                    <option value="Técnico en Ingeniería Biomédica"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Ingeniería Biomédica' ? 'selected' : '' }}>Técnico en Ingeniería Biomédica</option>
                                                    <option value="Técnico en Ingeniería en Computación"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Ingeniería en Computación' ? 'selected' : '' }}>Técnico en Ingeniería en Computación</option>
                                                    <option value="Técnico en Multimedia"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Multimedia' ? 'selected' : '' }}>Técnico en Multimedia</option>
                                                    <option value="Técnico en Diseño Gráfico"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Diseño Gráfico' ? 'selected' : '' }}>Técnico en Diseño Gráfico</option>
                                                    <option value="Técnico en Control de la Calidad"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Control de la Calidad' ? 'selected' : '' }}>Técnico en Control de la Calidad</option>
                                                    <option value="Técnico en Mantenimiento Aeronáutico"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Mantenimiento Aeronáutico' ? 'selected' : '' }}>Técnico en Mantenimiento Aeronáutico</option>
                                                    <option value="Técnico en Ortesis y Prótesis (semi-presencial)"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Ortesis y Prótesis (semi-presencial)' ? 'selected' : '' }}>Técnico en Ortesis y Prótesis (semi-presencial)</option>
                                                    <option value="Técnico en Guía de Turismo Bilingüe"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Guía de Turismo Bilingüe' ? 'selected' : '' }}>Técnico en Guía de Turismo Bilingüe</option>
                                                    <option value="Técnico en Asesoría Financiera Sostenible"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Asesoría Financiera Sostenible' ? 'selected' : '' }}>Técnico en Asesoría Financiera Sostenible</option>
                                                    <option value="Técnico en Gestión del Talento Humano"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Gestión del Talento Humano' ? 'selected' : '' }}>Técnico en Gestión del Talento Humano</option>
                                                    <option value="Técnico en Diseño Gráfico (Campus Antiguo Cuscatlán)"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Diseño Gráfico (Campus Antiguo Cuscatlán)' ? 'selected' : '' }}>Técnico en Diseño Gráfico (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Técnico en Multimedia (Campus Antiguo Cuscatlán)"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Multimedia (Campus Antiguo Cuscatlán)' ? 'selected' : '' }}>Técnico en Multimedia (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Técnico en Ingeniería en Computación (Campus Antiguo Cuscatlán)"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Ingeniería en Computación (Campus Antiguo Cuscatlán)' ? 'selected' : '' }}>Técnico en Ingeniería en Computación (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Técnico en Guía de Turismo Bilingüe (Campus Antiguo Cuscatlán)"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Guía de Turismo Bilingüe (Campus Antiguo Cuscatlán)' ? 'selected' : '' }}>Técnico en Guía de Turismo Bilingüe (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Técnico en Asesoría Financiera Sostenible (Campus Antiguo Cuscatlán)"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Asesoría Financiera Sostenible (Campus Antiguo Cuscatlán)' ? 'selected' : '' }}>Técnico en Asesoría Financiera Sostenible (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Técnico en Gestión del Talento Humano (Campus Antiguo Cuscatlán)"{{ $informacionUDB[0]->carreraUDB == 'Técnico en Gestión del Talento Humano (Campus Antiguo Cuscatlán)' ? 'selected' : '' }}>Técnico en Gestión del Talento Humano (Campus Antiguo Cuscatlán)</option>
                                                </optgroup>
                                                <optgroup label="Profesorados">
                                                    <option value="Profesorado en Teología Pastoral"{{ $informacionUDB[0]->carreraUDB == 'Profesorado en Teología Pastoral' ? 'selected' : '' }}>Profesorado en Teología Pastoral</option>
                                                </optgroup>
                                                <optgroup label="Maestrías">
                                                    <option value="Maestría en Educación"{{ $informacionUDB[0]->carreraUDB == 'Maestría en Educación' ? 'selected' : '' }}>Maestría en Educación</option>
                                                    <option value="Maestría en la Enseñanza de Lenguas Extranjeras"{{ $informacionUDB[0]->carreraUDB == 'Maestría en la Enseñanza de Lenguas Extranjeras' ? 'selected' : '' }}>Maestría en la Enseñanza de Lenguas Extranjeras</option>
                                                    <option value="Maestría en Dirección de Marketing"{{ $informacionUDB[0]->carreraUDB == 'Maestría en Dirección de Marketing' ? 'selected' : '' }}>Maestría en Dirección de Marketing</option>
                                                    <option value="Maestría en Ciencias Sociales (Cotitulación UCA-UDB)"{{ $informacionUDB[0]->carreraUDB == 'Maestría en Ciencias Sociales (Cotitulación UCA-UDB)' ? 'selected' : '' }}>Maestría en Ciencias Sociales (Cotitulación UCA-UDB)</option>
                                                    <option value="Maestría en Gestión del Currículum, Didáctica y Evaluación por Competencias"{{ $informacionUDB[0]->carreraUDB == 'Maestría en Gestión del Currículum, Didáctica y Evaluación por Competencias' ? 'selected' : '' }}>Maestría en Gestión del Currículum, Didáctica y Evaluación por Competencias</option>
                                                    <option value="Maestría en Seguridad y Gestión de Riesgos Informáticos"{{ $informacionUDB[0]->carreraUDB == 'Maestría en Seguridad y Gestión de Riesgos Informáticos' ? 'selected' : '' }}>Maestría en Seguridad y Gestión de Riesgos Informáticos</option>
                                                    <option value="Maestría en Gestión de la Calidad"{{ $informacionUDB[0]->carreraUDB == 'Maestría en Gestión de la Calidad' ? 'selected' : '' }}>Maestría en Gestión de la Calidad</option>
                                                    <option value="Maestría en Gestión Energética y Diseño Ambiental"{{ $informacionUDB[0]->carreraUDB == 'Maestría en Gestión Energética y Diseño Ambiental' ? 'selected' : '' }}>Maestría en Gestión Energética y Diseño Ambiental</option>
                                                    <option value="Maestría en Políticas para la Prevención de la Violencia Juvenil en Cultura de Paz"{{ $informacionUDB[0]->carreraUDB == 'Maestría en Políticas para la Prevención de la Violencia Juvenil en Cultura de Paz' ? 'selected' : '' }}>Maestría en Políticas para la Prevención de la Violencia Juvenil en Cultura de Paz</option>
                                                    <option value="Maestría en Arquitectura de Software"{{ $informacionUDB[0]->carreraUDB == 'Maestría en Arquitectura de Software' ? 'selected' : '' }}>Maestría en Arquitectura de Software</option>
                                                    <option value="Maestría en Gerencia de Mantenimiento Industrial (Cotitulación UCA-UDB)"{{ $informacionUDB[0]->carreraUDB == 'Maestría en Gerencia de Mantenimiento Industrial (Cotitulación UCA-UDB)' ? 'selected' : '' }}>Maestría en Gerencia de Mantenimiento Industrial (Cotitulación UCA-UDB)</option>
                                                    <option value="Maestría en Teología"{{ $informacionUDB[0]->carreraUDB == 'Maestría en Teología' ? 'selected' : '' }}>Maestría en Teología</option>
                                                </optgroup>
                                                <optgroup label="Doctorados">
                                                    <option value="Doctorado en Ciencias Sociales (Cotitulación UCA-UDB)"{{ $informacionUDB[0]->carreraUDB == 'Doctorado en Ciencias Sociales (Cotitulación UCA-UDB)' ? 'selected' : '' }}>Doctorado en Ciencias Sociales (Cotitulación UCA-UDB)</option>
                                                    <option value="Doctorado en Teología"{{ $informacionUDB[0]->carreraUDB == 'Doctorado en Teología' ? 'selected' : '' }}>Doctorado en Teología</option>
                                                    <option value="Doctorado en Educación"{{ $informacionUDB[0]->carreraUDB == 'Doctorado en Educación' ? 'selected' : '' }}>Doctorado en Educación</option>
                                                </optgroup>
                                                <optgroup label="Diplomados">
                                                    <option value="Diplomado de Especialización para la Administración de Windows Server"{{ $informacionUDB[0]->carreraUDB == 'Diplomado de Especialización para la Administración de Windows Server' ? 'selected' : '' }}>Diplomado de Especialización para la Administración de Windows Server</option>
                                                    <option value="Diplomado de Especialización en Configuración y Administración de LINUX RED HAT"{{ $informacionUDB[0]->carreraUDB == 'Diplomado de Especialización en Configuración y Administración de LINUX RED HAT' ? 'selected' : '' }}>Diplomado de Especialización en Configuración y Administración de LINUX RED HAT</option>
                                                    <option value="Diplomado de Especialización en Seguridad Informática"{{ $informacionUDB[0]->carreraUDB == 'Diplomado de Especialización en Seguridad Informática' ? 'selected' : '' }}>Diplomado de Especialización en Seguridad Informática</option>
                                                    <option value="Diplomado de Desarrollo de Aplicaciones Empresariales en JAVA"{{ $informacionUDB[0]->carreraUDB == 'Diplomado de Desarrollo de Aplicaciones Empresariales en JAVA' ? 'selected' : '' }}>Diplomado de Desarrollo de Aplicaciones Empresariales en JAVA</option>
                                                    <option value="Diplomado de Desarrollo de Aplicaciones Empresariales con Tecnologías.NET"{{ $informacionUDB[0]->carreraUDB == 'Diplomado de Desarrollo de Aplicaciones Empresariales con Tecnologías.NET' ? 'selected' : '' }}>Diplomado de Desarrollo de Aplicaciones Empresariales con Tecnologías.NET</option>
                                                    <option value="Diplomado de Especialización para la Gestión del Administrador de Bases de Datos"{{ $informacionUDB[0]->carreraUDB == 'Diplomado de Especialización para la Gestión del Administrador de Bases de Datos' ? 'selected' : '' }}>Diplomado de Especialización para la Gestión del Administrador de Bases de Datos</option>
                                                    <option value="Diplomado de Infraestructura en la Nube con AWS"{{ $informacionUDB[0]->carreraUDB == 'Diplomado de Infraestructura en la Nube con AWS' ? 'selected' : '' }}>Diplomado de Infraestructura en la Nube con AWS</option>
                                                    <option value="Diplomado de Especialización en Redes Informáticas (CCNA)"{{ $informacionUDB[0]->carreraUDB == 'Diplomado de Especialización en Redes Informáticas (CCNA)' ? 'selected' : '' }}>Diplomado de Especialización en Redes Informáticas (CCNA)</option>
                                                    <option value="Diplomado de Especialización en desarrollo de aplicaciones Front-End"{{ $informacionUDB[0]->carreraUDB == 'Diplomado de Especialización en desarrollo de aplicaciones Front-End' ? 'selected' : '' }}>Diplomado de Especialización en desarrollo de aplicaciones Front-End</option>
                                                    <option value="Diplomado de Implementación y Administración de Servicios en la nube Azure"{{ $informacionUDB[0]->carreraUDB == 'Diplomado de Implementación y Administración de Servicios en la nube Azure' ? 'selected' : '' }}>Diplomado de Implementación y Administración de Servicios en la nube Azure</option>
                                                    <option value="Diplomado en JAVA nivel Avanzado"{{ $informacionUDB[0]->carreraUDB == 'Diplomado en JAVA nivel Avanzado' ? 'selected' : '' }}>Diplomado en JAVA nivel Avanzado</option>
                                                    <option value="Diplomado Desarrollo de Aplicaciones Full Stack en Python"{{ $informacionUDB[0]->carreraUDB == 'Diplomado Desarrollo de Aplicaciones Full Stack en Python' ? 'selected' : '' }}>Diplomado Desarrollo de Aplicaciones Full Stack en Python</option>
                                                </optgroup>
                                                <optgroup label="Cursos">
                                                    <option value="Curso de Seguridad en la NUBE"{{ $informacionUDB[0]->carreraUDB == 'Curso de Seguridad en la NUBE' ? 'selected' : '' }}>Curso de Seguridad en la NUBE</option>
                                                    <option value="Curso de Preparación para la Certificación de Redes CCNA"{{ $informacionUDB[0]->carreraUDB == 'Curso de Preparación para la Certificación de Redes CCNA' ? 'selected' : '' }}>Curso de Preparación para la Certificación de Redes CCNA</option>
                                                    <option value="Curso de Metodología de Arquitectura en La Nube"{{ $informacionUDB[0]->carreraUDB == 'Curso de Metodología de Arquitectura en La Nube' ? 'selected' : '' }}>Curso de Metodología de Arquitectura en La Nube</option>
                                                    <option value="Curso de Implementación de redes SD-WAN empresariales"{{ $informacionUDB[0]->carreraUDB == 'Curso de Implementación de redes SD-WAN empresariales' ? 'selected' : '' }}>Curso de Implementación de redes SD-WAN empresariales</option>
                                                    <option value="Curso de Administración y configuración de Microsoft 365"{{ $informacionUDB[0]->carreraUDB == 'Curso de Administración y configuración de Microsoft 365' ? 'selected' : '' }}>Curso de Administración y configuración de Microsoft 365</option>
                                                </optgroup>
                              </select>
                                
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