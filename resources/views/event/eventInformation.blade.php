@extends('layout.header')

@section('title', 'Información de evento')

<body>
    <script src="{{ asset('js/inactividad.js') }}"></script>
    @include('layout.horizontalMenu')
    <div class="wrapper">
        @include('layout.verticalMenu')
        <div id="content" class="mt-0 pt-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 mx-5">
                <div class="container-fluid">
                    <a href="{{ route('events.index') }}" class="btn btn-light" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" data-bs-title="Regresar">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="col text-center">
                        <p style="color: black; margin: 0; font-weight: bold">Información del evento</p>
                    </div>
                </div>
            </nav>
            <div class="row">
                @foreach($eventInfo as $event)
                <div class="col-lg-4 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="d-flex justify-content-center">Información general del evento</p>
                            <div class="separator"></div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Nombre del evento: </b></div>
                                <div class="col-12">{{ $event->NombreEvento }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Lugar del evento: </b></div>
                                <div class="col-12">{{ $event->lugar }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Fecha del evento: </b></div>
                                <div class="col-12">{{ $event->fecha }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Hora del evento</b></div>
                                <div class="col-12">{{ $event->hora }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Descripción del evento</b></div>
                                <div class="col-12">{{ $event->descripcion }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Precio del evento</b></div>
                                <div class="col-12">{{ $event->precio }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Capacidad Maxima</b></div>
                                <div class="col-12">{{ $event->capacidad }} Personas</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xs-12">
                    <div class="card InfoTitlesSubjectsCard">
                        <div class="card-body titlesSubject-container">
                            <p class="d-flex justify-content-center">{{ $event->nombreArea }}</p>
                            <div class="separator"></div>
                            <div class="row mt-2">
                                <div class="col-lg-6 col-xs-12">
                                    <div class="col">
                                        <div class="col-12"><b>{{ $event->nombre }}</b></div>
                                        <div class="col-12"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body cardBody-Teachers">
                            <p class="d-flex justify-content-center">Imagen Promocional del Evento {{ $event->NombreEvento }}</p>
                            <div class="separator mb-3"></div>
                            <div class="row mt-2">
                                <div class="col-lg-6 col-xs-12">
                                    <div class="col">
                                        <img src="{{ asset($event->imagen) }}"
                                            alt="Imagen del evento {{ $event->NombreEvento }}" width="300px">
                                    </div>
                                    @if($purchaseLog->isEmpty())
                                    <div class="alert alert-warning" role="alert">
                                        No se han encontrado reservas para este evento
                                    </div>
                                    @else
                                    <div class="card-footer text-body-secondary d-flex justify-content-center">
                                        <a href="{{ route('viewEventLog.entry',$event->idEvento) }}" class="btn btn-primary my-1 mx-1" style="background-color: #2F98FE;">ver asistencias</a>
                                    </div>
                                    @endif
                                </div>
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
