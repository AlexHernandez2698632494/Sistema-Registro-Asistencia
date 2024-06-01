@extends('layout.header')


@section('title', 'Entradas Adquiridas')

<script src="{{ asset('js/sweetalert.js') }}"></script>

<body style="overflow-x: hidden">
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
                title: "Error al adquirir",
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
        @include('layout.verticalMenuInvitadoEstudiante')
        <div id="content" class="mt-0 pt-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 mx-5">
                <div class="container-fluid">
                    <a href="{{ route('StudentGuestSite.site') }}" class="btn btn-light" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" data-bs-title="Regresar">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="col text-center">
                        <p style="color: black; margin: 0; font-weight: bold">Entradas Adquiridas</p>
                    </div>
                </div>
            </nav>
            <div class="row mx-5">
                @if ($purchaseTicket->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        No se han encontrado registro de entradas Adquiridas
                    </div>
                @else
                    <div class="alert alert-primary" role="alert">
                        Entradas Adquiridas
                    </div>
                    @foreach ($purchaseTicket as $ticket)
                        <div class="col-lg-4 col-xl-6 col-md-6 col-xs-12 my-2">
                            <div class="card" style="height: 350px; max-height: 350px; width:450px; overflow-y: auto">
                                <div class="card-header" style="background-color: #2F98FE">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $ticket->NombreEvento }}</h5>
                                    <p><b>Fecha del Evento: </b>{{ $ticket->fecha }}</p>
                                    <p><b>Hora del Evento: </b>{{ $ticket->hora }}</p>
                                    <img src="{{ asset($ticket->qr_code) }}" alt="Código QR">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

</body>

</html>
