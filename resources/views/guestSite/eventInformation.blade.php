@extends('layout.header')



@section('title', 'Información de evento')

<body>
    <script src="{{ asset('js/inactividad.js') }}"></script>
    @include('layout.horizontalMenu')
    <div class="wrapper">
        @include('layout.verticalMenuInvitado')
        <div id="content" class="mt-0 pt-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 mx-5">
                <div class="container-fluid">
                    <a href="{{ route('guestSite.site') }}" class="btn btn-light" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" data-bs-title="Regresar">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="col text-center">
                        <p style="color: black; margin: 0; font-weight: bold">Información del evento</p>
                    </div>
                </div>
            </nav>
            <div class="row">
                @foreach($eventInfo as $eventInfo)
                <div class="col-lg-4 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="d-flex justify-content-center">Información general del evento</p>
                            <div class="separator"></div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Nombre del evento: </b></div>
                                <div class="col-12">{{ $eventInfo->NombreEvento }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Lugar del evento: </b></div>
                                <div class="col-12">{{ $eventInfo->lugar }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Fecha del evento: </b></div>
                                <div class="col-12">{{ $eventInfo->fecha }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Hora del evento</b></div>
                                <div class="col-12">{{ $eventInfo->hora }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Descripcion del evento</b></div>
                                <div class="col-12">{{ $eventInfo->descripcion }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Precio del evento</b></div>
                                <div class="col-12">{{ $eventInfo->precio }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xs-12">
                    <div class="card InfoTitlesSubjectsCard">
                        <div class="card-body titlesSubject-container">
                            <p class="d-flex justify-content-center">{{$eventInfo->nombreArea}}</p>
                            <div class="separator"></div>
                            <div class="row mt-2">
                                <div class="col-lg-6 col-xs-12">
                                    <div class="col">
                                        <div class="col-12"><b>{{$eventInfo->nombre}}</b></div>
                                        <div class="col-12"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body cardBody-Teachers">
                            <p class="d-flex justify-content-center">Imagen Promocional del Evento {{$eventInfo->NombreEvento}}</p>
                            <div class="separator mb-3"></div>
                            <div class="row mt-2">
                                <div class="col-lg-6 col-xs-12">
                                    <div class="col">
                                        <img src="{{ asset($eventInfo->imagen) }}"
                                            alt="Imagen de el evento {{ $eventInfo->NombreEvento }}" width="300px">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body cardBody-Teachers text-center">
                                {{-- Botón de inscripción individual --}}
                                <a href="{{ route('guestSite.ticketI', $eventInfo->idEvento) }}" class="btn btn-primary mx-2">
                                    Inscripción Individual
                                </a>
                                {{-- Botón de inscripción grupal --}}
                                <a href="{{ route('guestSite.ticketG', $eventInfo->idEvento) }}" class="btn btn-secondary mx-2">
                                    Inscripción Grupal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div> 
    </div>
</body>

</html>