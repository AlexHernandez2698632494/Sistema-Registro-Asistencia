@extends('layout.header')
 
 
 
@section('title','Registro de es')
 
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/admin/addInit.js') }}"></script>
<body>  
    <script src="{{ asset('js/inactividad.js') }}"></script>    
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
                        <p style="color: black; margin: 0; font-weight: bold">Registro para editar administrador</p>
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
                  
                      
                        <form action="{{ route('admin.update',$personaEdit)}}" method="POST" >
                            @csrf        
                            @method("PUT")                  
                            <div class="row">
                                <div class="col-12">        
                                    <p class="d-flex justify-content-center mt-2 mb-0">Información general del administrador</p>
                                    <p class="d-flex justify-content-center mt-0 subtitle">Ingrese la información que se solicita</p>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-lg-3 col-xs-12 mt-2">                                    
                                    <label for="nombre" class="form-label">Nombre</label>                                
                                    <input type="text" id="nombre" name="nombre" placeholder="Ingrese nombre" class="form-control input"  value="{{$personaEdit->nombre}}" required>                                    
                                </div>
                                <div class="col-lg-3 col-xs-12 mt-2">
                                    <label for="apellido" class="form-label">Apellido</label>                                
                                    <input type="text" id="Apellido" name="apellido" placeholder="Ingrese apellido" class="form-control input" value="{{$personaEdit->apellido}}" required>
                                </div>
                            </div>          
                            <div class="row mt-2 justify-content-center">
                                <div class="col-lg-3 col-xs-12 mt-2">
                                    <label for="dui" class="form-label">DUI</label>                                
                                    <input type="text" id="dui"  name="dui" placeholder="Ingrese dui" class="form-control input" value="{{$personaEdit->dui}}" required>                                
                                </div>
                                <div class="col-lg-3 col-xs-12 mt-2">
                                    <label for="telefono" class="form-label">Número de teléfono/celular</label>                                
                                    <input type="text" id="telefono" name="telefono" placeholder="Ingrese número" class="form-control input Phone" value="{{$personaEdit->telefono}}">                                                                                                    
                                </div>                                
                            </div>  
                            <div class="row mt-2 justify-content-center">
                                <div class="col-lg-6 col-xs-12 mt-2">                                    
                                    <label for="correo" class="form-label">Correo electrónico</label>                                
                                    <input type="email" id="correo"  placeholder="Ingrese correo" name="correo" class="form-control  input" value="{{$personaEdit->correo}}" required>                                    
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-lg-3 col-xs-12 mt-2">                                    
                                    <label for="direccion" class="form-label">Direccion</label>                                
                                    <input type="text" id="direccion" name="direccion" placeholder="Ingrese direccion" class="form-control input"  value="{{$personaEdit->direccion}}" >                                    
                                </div>
                                <div class="col-lg-3 col-xs-12 mt-2">
                                  
                                </div>
                            </div>                                                                                                                                                          
                            <div class="row mx-2 my-2">
                                <div class="col d-flex justify-content-center">
                                    <button type="submit" class="btn btn-block btn-Add">Actualizar administrador</button>
                                </div>								
                            </div>
                        </form>
                </div>
            </div>              
        </div>                                          
    </div>          
</body>
 
</html>