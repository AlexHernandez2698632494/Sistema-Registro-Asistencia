@extends('layout.header')
 
 
 
@section('title','Registro de es')
 
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/admin/addInit.js') }}"></script>
<body>  
    <script src="{{ asset('js/inactividad.js') }}"></script>    
   
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
                    <a href="{{ route('events.index') }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regresar">
                        <i class="fas fa-arrow-left"></i>
                    </a>                    
                    <div class="col text-center">
                        <p style="color: black; margin: 0; font-weight: bold">Registro para editar eventos</p>
                    </div>
                </div>
            </nav>       
           
              
            <div class="card teacherAdd-Card" id="data">
                <div class="card-body">
                <p class="d-flex justify-content-center">Registro de eventos</p>
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
                  
                      
                        <form action="{{ route('events.update',$eventEdit)}}" method="POST"  enctype="multipart/form-data">
                            @csrf        
                            @method("PUT")                  
                            <div class="row">
                                <div class="col-12">        
                                    <p class="d-flex justify-content-center mt-2 mb-0">Información general del eventos</p>
                                    <p class="d-flex justify-content-center mt-0 subtitle">Ingrese la información que se solicita</p>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-lg-3 col-xs-12 mt-2">                                    
                                    <label for="NombreEvento" class="form-label">Nombre</label>                                
                                    <input type="text" id="NombreEvento" name="NombreEvento" placeholder="Ingrese NombreEvento del evento" class="form-control input"  value="{{$eventEdit->NombreEvento}}" required>                                    
                                </div>
                                <div class="col-lg-3 col-xs-12 mt-2">
                                    <label for="lugar" class="form-label">Lugar</label>                                
                                    <input type="text" id="lugar" name="lugar" placeholder="Ingrese lugar" class="form-control input" value="{{$eventEdit->lugar}}" required>
                                </div>
                            </div>          
                            <div class="row mt-2 justify-content-center">
                                <div class="col-lg-3 col-xs-12 mt-2">
                                    <label for="fecha" class="form-label">Fecha :</label>                                
                                    <input type="date" id="fecha" name="fecha" placeholder="Ingrese número" class="form-control input Phone" value="{{$eventEdit->fecha}}">                                                                                                    
                                </div>
                                <div class="col-lg-3 col-xs-12 mt-2">
                                    <label for="" class="form-label">Hora</label>                                
                                    <input type="time" id="hora"  name="hora" placeholder="Ingrese hora" class="form-control input" value="{{$eventEdit->hora}}" required>                                
                                </div>                               
                            </div>  
                            <div class="row justify-content-center">
                                <div class="col-lg-3 col-xs-12 mt-2">
                                    <label for="descripcion" class="form-label">Descripcion</label>                                
                                    <input type="text" id="descripcion" name="descripcion" placeholder="Ingrese número" class="form-control input Phone" value="{{$eventEdit->descripcion}}">                                                                                                    
                                </div>
                                <div class="col-lg-3 col-xs-12 mt-2">                                    
                                    <label for="precio" class="form-label">precio</label>                                
                                    <input type="text" id="precio" name="precio" placeholder="Ingrese precio" class="form-control input"  value="{{$eventEdit->precio}}" >                                    
                                </div>
                            </div>  
                            <div class="row justify-content-center">
                                 <div class="col-lg-6 col-xs-12 mt-2">                                    
                                    <label for="imagen" class="form-label">imagen</label>                                
                                    <input type="file" id="imagen" name="imagen" placeholder="Ingrese imagen" class="form-control input"  value="{{$eventEdit->imagen}}" >                                    
                                </div>
                            </div>                                                                                                                                                     
                            <div class="row mx-2 my-2">
                                <div class="col d-flex justify-content-center">
                                    <button type="submit" class="btn btn-block btn-Add">Registrar evento</button>
                                </div>								
                            </div>
                        </form>
                </div>
            </div>              
        </div>                                          
    </div>          
</body>
 
</html>