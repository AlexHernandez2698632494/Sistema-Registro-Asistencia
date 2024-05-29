@extends('layout.header')


@section('title','Entradas Adquiridas')

<script src="{{ asset('js/sweetalert.js') }}"></script>

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
        @include('layout.verticalMenuInvitadoPersonalUDB')
        <div id="content" class="mt-0 pt-0">            
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 mx-5">
                <div class="container-fluid">                    
                    <a href="{{ route('UDBStaffGuestSite.site') }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regresar">
                        <i class="fas fa-arrow-left"></i>
                    </a>                    
                    <div class="col text-center">
                        <p style="color: black; margin: 0; font-weight: bold">Entradas Adquiridas</p>
                    </div>
                </div>
            </nav>
            <div class="row mx-5">
                @if($guestInfo->isEmpty())
                   <div class="alert alert-warning" role="alert">
                        No se han encontrado Eventos Disponibles
                    </div>  
                    @else 
                    <div class="alert alert-primary" role="alert">
                    Eventos Disponibles<b></b>
                    </div>
                     <div class="col-md-6">
                      @foreach($formativa as $info)
                      @if($info->nombreArea == 'Area Formativa')
                      <div class="col-lg-4 col-xl-6 col-md-6 col-xs-12 my-2">
                                <div class="card" style="height: 350px; max-height: 350px; width:450px; overflow-y: auto">
                                    <div class="card-header" style="background-color: #2F98FE">                          
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{$info->NombreEvento}}</h5>
                                        <p><b>Fecha del Evento: </b>{{$info->fecha}}</p>
                                        <p><b>Hora del Evento: </b>{{$info->hora}}</p>
                                        <img src="{{ asset($info->qr_code) }}" alt="Código QR">
                                    </div>
                                </div>
                            </div>
                      @endif
                      @endforeach
                    </div>
                    <!-- Area Entretenimiento -->
                    <div class="col-md-6">
                      @foreach($entretenimiento as $info)
                      @if($info->nombreArea == 'Area Entretenimiento')
                      <div class="col-lg-4 col-xl-6 col-md-6 col-xs-12 my-2">
                                <div class="card" style="height: 350px; max-height: 350px; width:475px; overflow-y: auto">
                                    <div class="card-header" style="background-color: #2F98FE">                          
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{$info->NombreEvento}}</h5>
                                        <p><b>Fecha del Evento: </b>{{$info->fecha}}</p>
                                        <p><b>Hora del Evento: </b>{{$info->hora}}</p>
                                        <img src="{{ asset($info->qr_code) }}" alt="Código QR">
                                    </div>
                                    <div class="card-footer text-body-secondary d-flex justify-content-center">
                                        <a href="{{ route('UDBStaffGuestSite.showInfo', $info->idEvento) }}" class="btn btn-primary my-1 mx-1" style="background-color: #2F98FE;">Información</a>
                                    </div>
                                </div>
                            </div>
                      @endif
                      @endforeach
                    </div> 
                @endif
            </div>                                              
        </div>
    </div>  
   
</body>
</html>