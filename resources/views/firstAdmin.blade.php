@extends('layout.header')

@section('title', 'Login')

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
    <section style="background-color: #0060B4;">
        <div class="container py-5 h-200">
            <div class="row d-flex justify-content-center align-items-center h-200">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">            
                            <h3 class="mb-1">Registro del primer administrador</h3>                            
                                
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
                            <form method="POST" action="{{ route('storeFirstAdmin') }}">
                                @csrf
                                <div class="row">
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
                                    <div class="col-lg-12 col-md-6 col-xs-12">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1"><i class="bi-solid bi-gender-ambiguous"></i></span>
                                            <select class="form-select" aria-label="Default select example" id="txtSex" name="sexo">
                                                <option value="" disabled selected>Seleccione su sexo</option>
                                                <option value="Masculino">Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-xs-12">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-address-card"></i></span>
                                            <input type="text" class="form-control" placeholder="Ingrese carné" aria-label="carnet" id="txtCarnetAdmin" name="carnet" value="{{ old('carnet') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-xs-12">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
                                            <input type="text" class="form-control" placeholder="Ingrese cargo" aria-label="cargo" name="cargo" value="{{ old('cargo') }}">
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
                                    
                                    <div class="col-lg-12 col-md-6 col-xs-12">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
                                            <input type="text" class="form-control" placeholder="Ingrese usuario" aria-label="usuario" name="usuario" value="{{ old('usuario') }}">
                                        </div>
                                    </div>      
                                    <div class="col-lg-12 col-md-6 col-xs-12">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
                                            <input type="password" class="form-control" placeholder="Ingrese contraseña" aria-label="password" name="password">
                                        </div>
                                    </div>                                 
                                </div>
                                <div class="row">
                                    <button class="btn btn-primary btn-lg btn-block mt-2" style="background-color: #0060B4;" type="submit">Registrar</button>
                                </div>                                                                                
                            </form>        
                        </div>                                        
                    </div>
                </div>
            </div>
        </div>
    </section>     
</body>
</html>
