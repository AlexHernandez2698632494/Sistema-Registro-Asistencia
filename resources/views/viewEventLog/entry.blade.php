@extends('layout.header')



@section('title', 'Información de evento')

<body>
    <script src="{{ asset('js/inactividad.js') }}"></script>
    @if (session('exito'))
    <script>
        swal({
            title: "Confirmacion ",
            text: "{{ session('exito') }}",
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

@if (session('error'))
    <script>
        swal({
            title: "Error al adquirir",
            text: "{{ session('error') }}",
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
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 mx-5">
                <div class="container-fluid">
                    <a href="{{ route('events.index') }}" class="btn btn-light" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" data-bs-title="Regresar">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="col text-center">
                        <p style="color: black; margin: 0; font-weight: bold">Información del usuario</p>
                    </div>
                </div>
            </nav>
            <div class="row justify-content-center">
                 @foreach($purchaseLog as $purchaseRecord) 
                <div class="col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="d-flex justify-content-center">Información general del evento</p>
                            <div class="separator"></div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Nombre del evento: </b></div>
                                <div class="col-12">{{ $purchaseRecord->NombreEvento }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Nombre del Usuario: </b></div>
                                <div class="col-12">{{ $purchaseRecord->nombre }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Sexo: </b></div>
                                <div class="col-12">{{ $purchaseRecord->sexo }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Institucion Educativa: </b></div>
                                <div class="col-12">{{ $purchaseRecord->institucion }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Nivel Academico: </b></div>
                                <div class="col-12">{{ $purchaseRecord->nivel_educativo }}</div>
                            </div>
                            <div class="card-footer text-body-secondary d-flex justify-content-center">
                                <form action="{{ route('confirmAsistencia', $purchaseRecord->idEventEntry) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary my-1 mx-1" style="background-color: #2F98FE;">
                                        Confirmar Asistencia
                                    </button>
                                </form>
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