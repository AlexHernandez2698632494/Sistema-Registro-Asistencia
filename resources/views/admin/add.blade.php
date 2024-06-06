@extends('layout.header')
 
 
 
@section('title','Registro de es')
 
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
 
    @include('layout.horizontalMenu')    
    <div class="wrapper">
        @include('layout.verticalMenu')
        <div id="content" class="mt-0 pt-0">              
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3">
                <div class="container-fluid">                    
                    <a href="{{ route('admin.index') }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regresar">
                        <i class="fas fa-arrow-left"></i>
                    </a>                    
                    <div class="col text-center">
                        <p style="color: black; margin: 0; font-weight: bold">Registro de nuevo administrador</p>
                    </div>
                </div>
            </nav>                      
            <div class="card teacherAdd-Card" id="data">
                <div class="card-body">
                <p class="d-flex justify-content-center">Registro de administrador</p>
                    <div class="separator"></div>
                    @if ($errors->any())
                        <div class="alert alert-danger my-2 pb-0">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif                          
                        <form method="POST" action="{{ route('admin.add') }}">
                            @csrf                          
                            <div class="row">
                                <div class="col-12">        
                                    <p class="d-flex justify-content-center mt-2 mb-0">Información general del administrador</p>
                                    <p class="d-flex justify-content-center mt-0 subtitle">Ingrese la información que se solicita</p>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-lg-3 col-xs-12 mt-2">                                    
                                    <label for="nombre" class="form-label">Nombre</label>                                
                                    <input type="text" id="nombre" name="nombre" placeholder="Ingrese nombre" class="form-control input"  value="{{old('nombre')}}" required>                                    
                                </div>
                                <div class="col-lg-3 col-xs-12 mt-2">
                                    <label for="apellido" class="form-label">Apellido</label>                                
                                    <input type="text" id="Apellido" name="apellido" placeholder="Ingrese apellido" class="form-control input" value="{{old('apellido')}}" required>
                                </div>
                            </div>          
                            <div class="row mt-2 justify-content-center">
                                <div class="col-lg-3 col-xs-12 mt-2">
                                    <label for="dui" class="form-label">Sexo</label>                        
											<select class="form-select" aria-label="Default select example" id="txtSex" name="sexo">
												<option value="" disabled selected>Ingrese su sexo</option>
												<option value="Masculino">Masculino</option>
												<option value="Femenino">Femenino</option>
											</select>
                            </div>
                                <div class="col-lg-3 col-xs-12 mt-2">
                                    <label for="carnet" class="form-label">Carnet</label>                                
                                    <!-- {{-- <input type="text" id="carnet" name="carnet" placeholder="Ingrese su carnet" class="form-control input Phone" value="{{old('telefono')}}">                                                                                                     --}} -->
                                    <input type="text" class="form-control txtCarnetAdmin" id="txtCarnetAdmin" placeholder="Ingrese su carnet" aria-label="carnet" name="carnet" value="{{old('carnet')}}">                
                                </div>                                
                            </div>  
                            <div class="row mt-2 justify-content-center">
                                <div class="col-lg-6 col-xs-12 mt-2">                                    
                                    <label for="correo" class="form-label">Correo electrónico</label>                                
                                    <input type="email" id="correo"  placeholder="Ingrese correo" name="correo" class="form-control  input" value="{{old('correo')}}" required>                                    
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-lg-3 col-xs-12 mt-2">                                    
                                <label for="telefono" class="form-label">Número de teléfono/celular</label>                                
                                    {{-- <input type="text" id="telefono" name="telefono" placeholder="Ingrese número" class="form-control input Phone" value="{{old('telefono')}}">                                                                                                     --}}
                                    <input type="text" class="form-control txtPhone" id="txtPhone" placeholder="Ingrese número de teléfono" aria-label="phone" name="telefono" value="{{old('telefono')}}">                
                                </div>
                                <div class="col-lg-3 col-xs-12 mt-2">
                                    <label for="cargo" class="form-label">Cargo</label>                                
                                    <input type="text" id="cargo" name="cargo" placeholder="Ingresar Cargo" class="form-control input" value="{{old('cargo')}}" >
                                </div>
                            </div>   
                            <div class="row justify-content-center">
                                <div class="col-lg-3 col-xs-12 mt-2">                                    
                                    <label for="usuario" class="form-label">Usuario</label>                                
                                    <input type="text" id="usuario" name="usuario" placeholder="Ingrese Usuario" class="form-control input"  value="{{old('usuario')}}" >                                    
                                </div>
                                <div class="col-lg-3 col-xs-12 mt-2">
                                    <label for="password" class="form-label">Contraseña</label>                                
                                    <input type="password" id="password" name="password" placeholder="Ingresar Contraseña" class="form-control input" value="{{old('password')}}" >
                                </div>
                                
                            </div>  
                                                                                                                                                                                   
                            <div class="row mx-2 my-2 mt-3">
                                <div class="col d-flex justify-content-center">
                                    <button type="submit" class="btn btn-block btn-Add">Registrar </button>
                                </div>                              
                            </div>
                        </form>
                </div>
            </div>              
        </div>                                          
    </div>          
</body>
 
</html>