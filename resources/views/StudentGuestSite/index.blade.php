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
    
                                <form method="POST" action="{{ route('StudentGuestSite.add') }}">
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
											<input type="text" class="form-control" placeholder="Ingrese nombre" aria-label="name" name="nombre" value="{{ old('nombre') }}">
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
											<input type="text" class="form-control" placeholder="Ingrese apellido" aria-label="lastName" name="apellidos" value="{{ old('apellidos') }}">
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
                                    <div class="col-lg-12  col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="bi bi-mortarboard-fill"></i></span>
											<select class="form-select" aria-label="Default select example" id="txtSex" name="nivelEducativo">
                                                <option value="" disabled selected>Ingrese su nivel educativo</option>  
                                                    <option value="Parvularia">Parvularia</option>
                                                    <option value="Basica">Basica</option>
                                                    <option value="Tercer Ciclo">Tercer Ciclo</option>
                                                    <option value="Bachillerato">Bachillerato</option>    
                                                    <option value="Universitario">Universitario</option>                                              
                                            </select>
										</div>
									</div>
                                    <div class="col-lg-12 col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
											<input type="text" class="form-control" placeholder="Ingrese Nombre Institución" aria-label="institución" name="institucion" value="{{ old('institucion') }}">
										</div>
									</div>
                                    <div class="col-lg-12 col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-address-card"></i></span>
											<input type="text" class="form-control" placeholder="Ingrese su carnet" aria-label="carnet" id="txtCarnetEstudiante" name="carnet" value="{{ old('carnet') }}">
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
											<input type="email" class="form-control" placeholder="Correo" aria-label="correo" name="correo" value="{{ old('correo') }}">
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-phone"></i></span>
											<input type="text" class="form-control" placeholder="Ingrese teléfono" aria-label="phone" id="txtPhone" name="telefono" value="{{ old('telefono') }}">
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