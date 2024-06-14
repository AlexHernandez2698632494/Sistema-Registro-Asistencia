@extends('layout.header')

@section('title', 'Login')

<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/admin/addInit.js') }}"></script>

<body>
    {{-- <script src="{{ asset('js/inactividad.js') }}"></script>     --}}
    @if (session('exitoAgregar'))
        <script>
            swal({
                title: "Registro agregado",
                text: "{{ session('exitoAgregar') }}",
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

    @if (session('errorAgregar'))
        <script>
            swal({
                title: "Error al registrar",
                text: "{{ session('errorAgregar') }}",
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

    <body>
        <section class="vh-200" style="background-color: #0060B4;">
            <div class="container py-5 h-200">
                <div class="row d-flex justify-content-center align-items-center h-200">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card shadow-2-strong" style="border-radius: 1rem;">
                                                <!-- Agregamos el botón en la esquina izquierda -->
                        <div class="d-flex justify-content-start">
                            <a href="{{ route('welcome') }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regresar">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                            <div class="card-body p-5 text-center">
                                    <form method="POST" action="{{ route('UDBStudentGuestSite.add') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="d-flex justify-content-center mt-0 subtitle">Ingrese la
                                                información que se solicita</p>
                                        </div>
                                    </div>
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
									<div class="col-lg-12 col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
											<input type="text" class="form-control" placeholder="Ingrese nombre" aria-label="name" name="nombreUDB" value="{{ old('nombreUDB') }}">
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
											<input type="text" class="form-control" placeholder="Ingrese apellido" aria-label="lastName" name="apellidosUDB" value="{{ old('apellidosUDB') }}">
										</div>
									</div>
									<div class="col-lg-12  col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="bi-solid bi-gender-ambiguous"></i></span>
											<select class="form-select" aria-label="Default select example" id="txtSex" name="sexo">
												<option value="" disabled selected>Ingrese su sexo</option>
												<option value="Masculino">Masculino</option>
												<option value="Femenino">Femenino</option>
											</select>
										</div>
									</div>
									 <div class="col-lg-12 col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-address-card"></i></span>
											<input type="text" class="form-control" placeholder="Ingrese su carnet" aria-label="carnet" id="txtCarnetEstudianteUDB" name="carnetUDB" value="{{ old('carnetUDB') }}">
										</div>
									</div>
                                    <div class="col-lg-12  col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="bi bi-mortarboard-fill"></i></span>
											<select class="form-select" aria-label="Default select example" id="txtSex" name="carrera">
                                                <option value="" disabled selected>Ingrese su carrera</option>
                                                <optgroup label="Ingenierías">
                                                    <option value="Ingeniería Mecánica">Ingeniería Mecánica</option>
                                                    <option value="Ingeniería Industrial">Ingeniería Industrial</option>
                                                    <option value="Ingeniería Biomédica">Ingeniería Biomédica</option>
                                                    <option value="Ingeniería en Ciencias de la Computación">Ingeniería en Ciencias de la Computación</option>
                                                    <option value="Ingeniería Eléctrica">Ingeniería Eléctrica</option>
                                                    <option value="Ingeniería Mecatrónica">Ingeniería Mecatrónica</option>
                                                    <option value="Ingeniería en Aeronáutica">Ingeniería en Aeronáutica</option>
                                                    <option value="Ingeniería Electrónica y Automatización">Ingeniería Electrónica y Automatización</option>
                                                    <option value="Ingeniería en Telecomunicaciones y Redes">Ingeniería en Telecomunicaciones y Redes</option>
                                                    <option value="Ingeniería Industrial (Campus Antiguo Cuscatlán)">Ingeniería Industrial (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Ingeniería en Ciencias de la Computación (Campus Antiguo Cuscatlán)">Ingeniería en Ciencias de la Computación (Campus Antiguo Cuscatlán)</option>
                                                </optgroup>
                                                <optgroup label="Licenciaturas">
                                                    <option value="Licenciatura en Teología Pastoral">Licenciatura en Teología Pastoral</option>
                                                    <option value="Licenciatura en Idiomas con Especialidad en la Adquisición de Lenguas Extranjeras">Licenciatura en Idiomas con Especialidad en la Adquisición de Lenguas Extranjeras</option>
                                                    <option value="Licenciatura en Idiomas con Especialidad en Turismo">Licenciatura en Idiomas con Especialidad en Turismo</option>
                                                    <option value="Licenciatura en Ciencias de la Comunicación">Licenciatura en Ciencias de la Comunicación</option>
                                                    <option value="Licenciatura en Diseño Gráfico">Licenciatura en Diseño Gráfico</option>
                                                    <option value="Licenciatura en Diseño Industrial">Licenciatura en Diseño Industrial</option>
                                                    <option value="Licenciatura en Marketing">Licenciatura en Marketing</option>
                                                    <option value="Licenciatura en Contaduría Pública">Licenciatura en Contaduría Pública</option>
                                                    <option value="Licenciatura en Administración de Empresas">Licenciatura en Administración de Empresas</option>
                                                    <option value="Licenciatura en Marketing (Campus Antiguo Cuscatlán)">Licenciatura en Marketing (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Licenciatura en Idiomas Turismo (Campus Antiguo Cuscatlán)">Licenciatura en Idiomas Turismo (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Licenciatura en Diseño Gráfico (Campus Antiguo Cuscatlán)">Licenciatura en Diseño Gráfico (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Licenciatura en Ciencias de la Comunicación (Campus Antiguo Cuscatlán)">Licenciatura en Ciencias de la Comunicación (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Licenciatura en Administración de Empresas (Campus Antiguo Cuscatlán)">Licenciatura en Administración de Empresas (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Licenciatura en Idiomas con Especialidad en la Adquisición de Lenguas Extranjeras (Campus Antiguo Cuscatlán)">Licenciatura en Idiomas con Especialidad en la Adquisición de Lenguas Extranjeras (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Licenciatura en Contaduría Pública (Campus Antiguo Cuscatlán)">Licenciatura en Contaduría Pública (Campus Antiguo Cuscatlán)</option>
                                                </optgroup>
                                                <optgroup label="Técnicos">
                                                    <option value="Técnico en Ingeniería Mecánica">Técnico en Ingeniería Mecánica</option>
                                                    <option value="Técnico en Ingeniería Eléctrica">Técnico en Ingeniería Eléctrica</option>
                                                    <option value="Técnico en Ingeniería Electrónica">Técnico en Ingeniería Electrónica</option>
                                                    <option value="Técnico en Ingeniería Biomédica">Técnico en Ingeniería Biomédica</option>
                                                    <option value="Técnico en Ingeniería en Computación">Técnico en Ingeniería en Computación</option>
                                                    <option value="Técnico en Multimedia">Técnico en Multimedia</option>
                                                    <option value="Técnico en Diseño Gráfico">Técnico en Diseño Gráfico</option>
                                                    <option value="Técnico en Control de la Calidad">Técnico en Control de la Calidad</option>
                                                    <option value="Técnico en Mantenimiento Aeronáutico">Técnico en Mantenimiento Aeronáutico</option>
                                                    <option value="Técnico en Ortesis y Prótesis (semi-presencial)">Técnico en Ortesis y Prótesis (semi-presencial)</option>
                                                    <option value="Técnico en Guía de Turismo Bilingüe">Técnico en Guía de Turismo Bilingüe</option>
                                                    <option value="Técnico en Asesoría Financiera Sostenible">Técnico en Asesoría Financiera Sostenible</option>
                                                    <option value="Técnico en Gestión del Talento Humano">Técnico en Gestión del Talento Humano</option>
                                                    <option value="Técnico en Diseño Gráfico (Campus Antiguo Cuscatlán)">Técnico en Diseño Gráfico (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Técnico en Multimedia (Campus Antiguo Cuscatlán)">Técnico en Multimedia (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Técnico en Ingeniería en Computación (Campus Antiguo Cuscatlán)">Técnico en Ingeniería en Computación (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Técnico en Guía de Turismo Bilingüe (Campus Antiguo Cuscatlán)">Técnico en Guía de Turismo Bilingüe (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Técnico en Asesoría Financiera Sostenible (Campus Antiguo Cuscatlán)">Técnico en Asesoría Financiera Sostenible (Campus Antiguo Cuscatlán)</option>
                                                    <option value="Técnico en Gestión del Talento Humano (Campus Antiguo Cuscatlán)">Técnico en Gestión del Talento Humano (Campus Antiguo Cuscatlán)</option>
                                                </optgroup>
                                                <optgroup label="Profesorados">
                                                    <option value="Profesorado en Teología Pastoral">Profesorado en Teología Pastoral</option>
                                                </optgroup>
                                                <optgroup label="Maestrías">
                                                    <option value="Maestría en Educación">Maestría en Educación</option>
                                                    <option value="Maestría en la Enseñanza de Lenguas Extranjeras">Maestría en la Enseñanza de Lenguas Extranjeras</option>
                                                    <option value="Maestría en Dirección de Marketing">Maestría en Dirección de Marketing</option>
                                                    <option value="Maestría en Ciencias Sociales (Cotitulación UCA-UDB)">Maestría en Ciencias Sociales (Cotitulación UCA-UDB)</option>
                                                    <option value="Maestría en Gestión del Currículum, Didáctica y Evaluación por Competencias">Maestría en Gestión del Currículum, Didáctica y Evaluación por Competencias</option>
                                                    <option value="Maestría en Seguridad y Gestión de Riesgos Informáticos">Maestría en Seguridad y Gestión de Riesgos Informáticos</option>
                                                    <option value="Maestría en Gestión de la Calidad">Maestría en Gestión de la Calidad</option>
                                                    <option value="Maestría en Gestión Energética y Diseño Ambiental">Maestría en Gestión Energética y Diseño Ambiental</option>
                                                    <option value="Maestría en Políticas para la Prevención de la Violencia Juvenil en Cultura de Paz">Maestría en Políticas para la Prevención de la Violencia Juvenil en Cultura de Paz</option>
                                                    <option value="Maestría en Arquitectura de Software">Maestría en Arquitectura de Software</option>
                                                    <option value="Maestría en Gerencia de Mantenimiento Industrial (Cotitulación UCA-UDB)">Maestría en Gerencia de Mantenimiento Industrial (Cotitulación UCA-UDB)</option>
                                                    <option value="Maestría en Teología">Maestría en Teología</option>
                                                </optgroup>
                                                <optgroup label="Doctorados">
                                                    <option value="Doctorado en Ciencias Sociales (Cotitulación UCA-UDB)">Doctorado en Ciencias Sociales (Cotitulación UCA-UDB)</option>
                                                    <option value="Doctorado en Teología">Doctorado en Teología</option>
                                                    <option value="Doctorado en Educación">Doctorado en Educación</option>
                                                </optgroup>
                                                <optgroup label="Diplomados">
                                                    <option value="Diplomado de Especialización para la Administración de Windows Server">Diplomado de Especialización para la Administración de Windows Server</option>
                                                    <option value="Diplomado de Especialización en Configuración y Administración de LINUX RED HAT">Diplomado de Especialización en Configuración y Administración de LINUX RED HAT</option>
                                                    <option value="Diplomado de Especialización en Seguridad Informática">Diplomado de Especialización en Seguridad Informática</option>
                                                    <option value="Diplomado de Desarrollo de Aplicaciones Empresariales en JAVA">Diplomado de Desarrollo de Aplicaciones Empresariales en JAVA</option>
                                                    <option value="Diplomado de Desarrollo de Aplicaciones Empresariales con Tecnologías.NET">Diplomado de Desarrollo de Aplicaciones Empresariales con Tecnologías.NET</option>
                                                    <option value="Diplomado de Especialización para la Gestión del Administrador de Bases de Datos">Diplomado de Especialización para la Gestión del Administrador de Bases de Datos</option>
                                                    <option value="Diplomado de Infraestructura en la Nube con AWS">Diplomado de Infraestructura en la Nube con AWS</option>
                                                    <option value="Diplomado de Especialización en Redes Informáticas (CCNA)">Diplomado de Especialización en Redes Informáticas (CCNA)</option>
                                                    <option value="Diplomado de Especialización en desarrollo de aplicaciones Front-End">Diplomado de Especialización en desarrollo de aplicaciones Front-End</option>
                                                    <option value="Diplomado de Implementación y Administración de Servicios en la nube Azure">Diplomado de Implementación y Administración de Servicios en la nube Azure</option>
                                                    <option value="Diplomado en JAVA nivel Avanzado">Diplomado en JAVA nivel Avanzado</option>
                                                    <option value="Diplomado Desarrollo de Aplicaciones Full Stack en Python">Diplomado Desarrollo de Aplicaciones Full Stack en Python</option>
                                                </optgroup>
                                                <optgroup label="Cursos">
                                                    <option value="Curso de Seguridad en la NUBE">Curso de Seguridad en la NUBE</option>
                                                    <option value="Curso de Preparación para la Certificación de Redes CCNA">Curso de Preparación para la Certificación de Redes CCNA</option>
                                                    <option value="Curso de Metodología de Arquitectura en La Nube">Curso de Metodología de Arquitectura en La Nube</option>
                                                    <option value="Curso de Implementación de redes SD-WAN empresariales">Curso de Implementación de redes SD-WAN empresariales</option>
                                                    <option value="Curso de Administración y configuración de Microsoft 365">Curso de Administración y configuración de Microsoft 365</option>
                                                </optgroup>
                                            </select>
										</div>
									</div>
                                    <div class="col-lg-12  col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="bi-solid bi-person-workspace"></i></span>
											<select class="form-select" aria-label="Default select example" id="txtEstado" name="estadoUDB">
												<option value="" disabled selected>Ingrese su estado</option>
												<option value="Activo">Activo</option>
												<option value="No Activo">No Activo</option>
                                                <option value="Graduado">Graduado</option>
											</select>
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
											<input type="email" class="form-control" placeholder="Correo" aria-label="correo" name="correoUDB" value="{{ old('correoUDB') }}">
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-phone"></i></span>
											<input type="text" class="form-control" placeholder="Ingrese telefono" aria-label="phone" id="txtPhone" name="telefonoUDB" value="{{ old('telefonoUDB') }}">
										</div>
									</div>
									<div class="col-lg-12  col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-map-location-dot"></i></span>
											<select class="form-select" aria-label="Default select example" id="txtDepartamento" name="departamento">
                                                <option value="" disabled selected>Ingrese su Departamento</option>
                                                <option value="Ahuachapán">Ahuachapán</option>
                                                <option value="Cabañas">Cabañas</option>
                                                <option value="Chalatenango">Chalatenango</option>
                                                <option value="Cuscatlán">Cuscatlán</option>
                                                <option value="La Libertad">La Libertad</option>
                                                <option value="La Paz">La Paz</option>
                                                <option value="La Unión">La Unión</option>
                                                <option value="Morazán">Morazán</option>
                                                <option value="San Miguel">San Miguel</option>
                                                <option value="San Salvador">San Salvador</option>
                                                <option value="San Vicente">San Vicente</option>
                                                <option value="Santa Ana">Santa Ana</option>
                                                <option value="Sonsonate">Sonsonate</option>
                                                <option value="Usulután">Usulután</option>
                                            </select>
										</div>
									</div>
									<div class="col-lg-12  col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-map-location-dot"></i></span>
											<select class="form-select" aria-label="Default select example" id="txtSex" name="municipio">
                                                <option value="" disabled selected>Ingrese su municipio</option>
                                                <!-- Ahuachapán -->
                                                <optgroup label="Ahuachapán">
                                                    <option value="Ahuachapán Centro">Ahuachapán Centro</option>
                                                    <option value="Ahuachapán Norte">Ahuachapán Norte</option>
                                                    <option value="Ahuachapán Sur">Ahuachapán Sur</option>
                                                </optgroup>
                                                <!-- Cabañas -->
                                                <optgroup label="Cabañas">
                                                    <option value="Cabañas Este">Cabañas Este</option>
                                                    <option value="Cabañas Oeste">Cabañas Oeste</option>
                                                </optgroup>
                                                <!-- Chalatenango -->
                                                <optgroup label="Chalatenango">
                                                    <option value="Chalatenango Centro">Chalatenango Centro</option>
                                                    <option value="Chalatenango Norte">Chalatenango Norte</option>
                                                    <option value="Chalatenango Sur">Chalatenango Sur</option>
                                                </optgroup>
                                                <!-- Cuscatlán -->
                                                <optgroup label="Cuscatlán">
                                                    <option value="Cuscatlan Norte">Cuscatlan Norte</option>
                                                    <option value="Cuscatlan Sur">Cuscatlan Sur</option>
                                                </optgroup>
                                                <!-- La Libertad -->
                                                <optgroup label="La Libertad">
                                                    <option value="La Libertad Centro">La Libertad Centro</option>
                                                    <option value="La Libertad Costa">La Libertad Costa</option>
                                                    <option value="La Libertad Este">La Libertad Este</option>
                                                    <option value="La Libertad Norte">La Libertad Norte</option>
                                                    <option value="La Libertad Oeste">La Libertad Oeste</option>
                                                    <option value="La Libertad Sur">La Libertad Sur</option>
                                                </optgroup>
                                                <!-- La Paz -->
                                                <optgroup label="La Paz">
                                                    <option value="La Paz Centro">La Paz Centro</option>
                                                    <option value="La Paz Este">La Paz Este</option>
                                                    <option value="La Paz Oeste">La Paz Oeste</option>
                                                </optgroup>
                                                <!-- La Unión -->
                                                <optgroup label="La Unión">
                                                    <option value="La Unión Norte">La Unión Norte</option>
                                                    <option value="La Unión Sur">La Unión Sur</option>
                                                </optgroup>
                                                <!-- Morazán -->
                                                <optgroup label="Morazán">
                                                    <option value="Morazán Norte">Morazán Norte</option>
                                                    <option value="Morazán Sur">Morazán Sur</option>
                                                </optgroup>
                                                <!-- San Miguel -->
                                                <optgroup label="San Miguel">
                                                    <option value="San Miguel Centro">San Miguel Centro</option>
                                                    <option value="San Miguel Norte">San Miguel Norte</option>
                                                    <option value="San Miguel Oeste">San Miguel Oeste</option>
                                                </optgroup>
                                                <!-- San Salvador -->
                                                <optgroup label="San Salvador">
                                                    <option value="San Salvador Centro">San Salvador Centro</option>
                                                    <option value="San Salvador Este">San Salvador Este</option>
                                                    <option value="San Salvador Norte">San Salvador Norte</option>
                                                    <option value="San Salvador Oeste">San Salvador Oeste</option>
                                                    <option value="San Salvador Sur">San Salvador Sur</option>
                                                </optgroup>
                                                <!-- San Vicente -->
                                                <optgroup label="San Vicente">
                                                    <option value="San Vicente Norte">San Vicente Norte</option>
                                                    <option value="San Vicente Sur">San Vicente Sur</option>
                                                </optgroup>
                                                <!-- Santa Ana -->
                                                <optgroup label="Santa Ana">
                                                    <option value="Santa Ana Centro">Santa Ana Centro</option>
                                                    <option value="Santa Ana Este">Santa Ana Este</option>
                                                    <option value="Santa Ana Norte">Santa Ana Norte</option>
                                                    <option value="Santa Ana Oeste">Santa Ana Oeste</option>
                                                </optgroup>
                                                <!-- Sonsonate -->
                                                <optgroup label="Sonsonate">
                                                    <option value="Sonsonate Centro">Sonsonate Centro</option>
                                                    <option value="Sonsonate Este">Sonsonate Este</option>
                                                    <option value="Sonsonate Norte">Sonsonate Norte</option>
                                                    <option value="Sonsonate Oeste">Sonsonate Oeste</option>
                                                </optgroup>
                                                <!-- Usulután -->
                                                <optgroup label="Usulután">
                                                    <option value="Usulután Este">Usulután Este</option>
                                                    <option value="Usulután Norte">Usulután Norte</option>
                                                    <option value="Usulután Oeste">Usulután Oeste</option>
                                                </optgroup>
                                            </select>
                                            
										</div>
									</div>
                                    <div class="row mx-2 my-2 mt-6">
                                        <div class="col d-flex justify-content-center">
                                            <button type="submit" class="btn btn-block btn-Add">Registrar </button>
                                        </div>
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