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
                            <div class="card-body p-5 text-center">
                                <form method="POST" action="{{ route('guestSite.add') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="d-flex justify-content-center mt-0 subtitle">Ingrese la
                                                información que se solicita</p>
                                        </div>
                                    </div>
									<div class="col-lg-12 col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
											<input type="text" class="form-control" placeholder="Ingrese nombre" aria-label="name" name="nombre" value="{{ old('nombre') }}">
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
											<input type="text" class="form-control" placeholder="Ingrese apellido" aria-label="lastName" name="apellido" value="{{ old('apellido') }}">
										</div>
									</div>
									<div class="col-lg-12  col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="bi-solid bi-gender-ambiguous"></i></span>
											<select class="form-select" aria-label="Default select example" id="txtSex" name="sexo">
												<option value="" disabled selected>Ingrese su sexualidad</option>
												<option value="Masculino">Masculino</option>
												<option value="Femenino">Femenino</option>
											</select>
										</div>
									</div>
									 <div class="col-lg-12 col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-address-card"></i></span>
											<input type="text" class="form-control" placeholder="Ingrese dui" aria-label="carnet" id="txtCarnetAdmin" name="carnet" value="{{ old('carnet') }}">
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
											<input type="text" class="form-control" placeholder="Ingrese telefono" aria-label="phone" id="txtPhone" name="telefono" value="{{ old('telefono') }}">
										</div>
									</div>
									<div class="col-lg-12  col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="bi-solid bi-gender-ambiguous"></i></span>
											<select class="form-select" aria-label="Default select example" id="txtSex" name="sexo">
												<option value="" disabled selected>Ingrese su Departamento</option>
												<option value="Masculino">Masculino</option>
												<option value="Femenino">Femenino</option>
											</select>
										</div>
									</div>
									<div class="col-lg-12  col-md-6 col-xs-12">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1"><i class="bi-solid bi-gender-ambiguous"></i></span>
											<select class="form-select" aria-label="Default select example" id="txtSex" name="sexo">
												<option value="" disabled selected>Ingrese su municipio</option>
												<option value="Masculino">Masculino</option>
												<option value="Femenino">Femenino</option>
											</select>
										</div>
									</div>
                                    {{-- <div class="row justify-content">
                                        <div class="col-lg-6 col-xs-12 mt-2">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" id="nombre" name="nombre"
                                                placeholder="Ingrese nombre" class="form-control input"
                                                value="{{ old('nombre') }}" required>
                                        </div>
                                        <div class="col-lg-6 col-xs-12 mt-2">
                                            <label for="apellido" class="form-label">Apellido</label>
                                            <input type="text" id="Apellido" name="apellido"
                                                placeholder="Ingrese apellido" class="form-control input"
                                                value="{{ old('apellido') }}" required>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="row mt-2 justify-content-center">
                                        <div class="col-lg-6 col-xs-12 mt-2">
                                            <label for="dui" class="form-label">DUI</label>
                                            <input type="text" class="form-control" placeholder="Ingrese DUI"
                                                aria-label="dui" id="txtDui" name="dui"
                                                value="{{ old('dui') }}">
                                        </div>
                                        <div class="col-lg-6 col-xs-12 mt-2">
                                            <label for="telefono" class="form-label">Número de teléfono</label>
                                            <input type="text" class="form-control txtPhone" id="txtPhone"
                                                placeholder="Ingrese número de teléfono" aria-label="phone"
                                                name="telefono" value="{{ old('telefono') }}">
                                        </div>
                                    </div> --}}
                                    {{-- <div class="row mt-2 justify-content">
                                        <div class="col-lg-6 col-xs-12 mt-2">
                                            <label for="direccion" class="form-label">Direccion</label>
                                            <input type="text" id="direccion" name="direccion"
                                                placeholder="Ingrese direccion" class="form-control input"
                                                value="{{ old('direccion') }}">
                                        </div>
                                        <div class="col-lg-6 col-xs-12 mt-2">
                                            <label for="correo" class="form-label">Correo electrónico</label>
                                            <input type="email" id="correo" placeholder="Ingrese correo"
                                                name="correo" class="form-control  input" value="{{ old('correo') }}"
                                                required>
                                        </div>
                                    </div> --}}


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
