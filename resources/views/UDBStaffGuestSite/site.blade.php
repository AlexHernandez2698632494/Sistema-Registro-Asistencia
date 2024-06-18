@extends('layout.header')
 
 
@section('title','Inicio invitados')
 
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/studentUDB/eventos.js') }}"></script>

<body style="overflow-x: hidden">    
    <script src="{{ asset('js/inactividad.js') }}"></script>
 
 
    @include('layout.horizontalMenu')    
    <div class="wrapper">
        @include('layout.verticalMenuInvitadoPersonalUDB')
        <div id="content" class="mt-0 pt-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 mx-5">
                <div class="container-fluid">                    
                    <div class="col d-flex justify-content-center">
                        <p style="color: black; margin: 0; font-weight: bold">Eventos Disponibles</p>
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
                        <div class="alert alert-primary" role="alert">
                            Eventos Formativos
                    </div>
                      @foreach($formativa as $info)
                      @if($info->nombreArea == 'Area Formativa')
                      <div class="col-lg-4 col-xl-6 col-md-6 col-xs-12 my-2">
                                <div class="card" style="height: 350px; max-height: 350px; width:475px; overflow-y: auto">
                                    <div class="card-header" style="background-color: #2F98FE">                          
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{$info->NombreEvento}}</h5>
                                        <p><b>Fecha del Evento: </b>{{$info->fecha}}</p>
                                        <p><b>Hora del Evento: </b>{{$info->hora}}</p>
                                        <p><b>Precio de la Entrada </b>{{$info->precio}}</p>
                                        <p><b>Descripcion </b>{{$info->descripcion}}</p>
                                    </div>
                                    <div class="card-footer text-body-secondary d-flex justify-content-center">
                                        <a href="{{ route('UDBStaffGuestSite.showInfo', $info->idEvento) }}" class="btn btn-primary my-1 mx-1" style="background-color: #2F98FE;">Información</a>
                                    </div>
                                </div>
                            </div>
                      @endif
                      @endforeach
                    </div>
                    <!-- Area Entretenimiento -->
                    <div class="col-md-6">
                        <div class="alert alert-primary" role="alert">
                            Eventos de Entrenimiento
                    </div>
                      @foreach($entrenimiento as $info)
                      @if($info->nombreArea == 'Area Entretenimiento')
                      <div class="col-lg-4 col-xl-6 col-md-6 col-xs-12 my-2">
                                <div class="card" style="height: 350px; max-height: 350px; width:475px; overflow-y: auto">
                                    <div class="card-header" style="background-color: #2F98FE">                          
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{$info->NombreEvento}}</h5>
                                        <p><b>Fecha del Evento: </b>{{$info->fecha}}</p>
                                        <p><b>Hora del Evento: </b>{{$info->hora}}</p>
                                        <p><b>Precio de la Entrada </b>{{$info->precio}}</p>
                                        <p><b>Descripcion </b>{{$info->descripcion}}</p>
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