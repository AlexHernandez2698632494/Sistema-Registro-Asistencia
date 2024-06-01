@extends('layout.header')
 
@section('title', 'Adquirir entrada')
 
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
        @include('layout.verticalMenuInvitadoEstudianteUDB')
        <div id="content" class="mt-0 pt-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 mx-5">
                <div class="container-fluid">
                    <a href="{{ route('UDBStudentGuestSite.site') }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regresar">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="col text-center">
                        <p style="color: black; margin: 0; font-weight: bold">Adquirir entradas</p>
                    </div>
                </div>
            </nav>
            <div class="card mx-5 mb-3">
                <div class="card-body">
                    <p class="d-flex justify-content-center">Información general</p>
                    <div class="separator mb-3"></div>
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
                    <form id="entradaForm" method="POST" action="{{ route('UDBStudentGuestSite.addEntry') }}">
                        @csrf
                        <div class="row mx-1">
                            <div class="col-lg-6 col-xs-12">
                                <p style="margin-bottom: 0; font-weight: bold" class="mt-2">Nombre Completo</p>
                                {{ $informacionUDB[0]->nombreUDB.' '.$informacionUDB[0]->apellidosUDB}}
                                <input type="hidden" name="nombre" value="{{ $informacionUDB[0]->nombreUDB.' '.$informacionUDB[0]->apellidosUDB }}">
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <p style="margin-bottom: 0; font-weight: bold" class="mt-2">Sexo</p>
                                {{ $informacionUDB[0]->sexoUDB}}
                                <input type="hidden" name="sexo" value="{{ $informacionUDB[0]->sexoUDB }}">
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <p style="margin-bottom: 0; font-weight: bold" class="mt-2">Institución</p>
                                 <p class="mt-2" value="UDB" name="institucionUDB">Universidad Don Bosco</p>
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <p style="margin-bottom: 0; font-weight: bold" class="mt-2">Carrera</p>
                                {{ $informacionUDB[0]->carreraUDB}}
                                <input type="hidden" name="nivel_educativo" value="{{ $informacionUDB[0]->carreraUDB }}">
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <p style="margin-bottom: 0; font-weight: bold" class="mt-2">Evento</p>
                                <select class="form-select" id="idEvento" name="idEvento" required>
                                    <option value="" disabled selected>Seleccione un evento</option>
                                    @foreach ($eventos as $evento)
                                        <option value="{{ $evento->idEvento }}">{{ $evento->NombreEvento }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mx-1 mt-3 d-flex justify-content-center">
                            <div class="col-lg-4">
                                <div class="btn-group d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary mt-2 btn-block">Ingresar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>