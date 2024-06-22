@extends('layout.header')

@section('title', 'Información de evento')
<script src="{{ asset('js/sweetalert.js') }}"></script>

<body>
    <script src="{{ asset('js/inactividad.js') }}"></script>
    @if (session('exito'))
    <script>
        swal({
            title: "Confirmación",
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
            title: "Error",
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
                    <a href="{{ route('events.index') }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regresar">
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
                                <div class="col-12"><b>Institución Educativa: </b></div>
                                <div class="col-12">{{ $purchaseRecord->institucion }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Nivel Académico: </b></div>
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
                @foreach($purchaseLogs as $purchaseRecord)
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
                                <div class="col-12"><b>Institución Educativa: </b></div>
                                <div class="col-12">{{ $purchaseRecord->institucion }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Nivel Académico: </b></div>
                                <div class="col-12">{{ $purchaseRecord->nivel_educativo }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12"><b>Cantidad: </b></div>
                                <div class="col-12">{{ $purchaseRecord->cantidad }}</div>
                            </div>
                            <div class="card-footer text-body-secondary d-flex justify-content-center">
                                <form action="{{ route('confirmAsistenciaG', $purchaseRecord->idEventEntry) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary my-1 mx-1" style="background-color: #2F98FE;">
                                        Confirmar Asistencia
                                    </button>
                                </form>
                                <form action="{{ route('editCantidad', $purchaseRecord->idEventEntry) }}" method="GET">
                                    @csrf
                                    <button type="button" onclick="openEditarCantidadModal({{ $purchaseRecord->idEventEntry }})" class="btn btn-secondary my-1 mx-1">
                                        Editar Cantidad
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

    <!-- Modal para editar cantidad -->
    <div class="modal fade" id="editarCantidadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Editar Cantidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('updateCantidad') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="editCantidadId" name="idEventEntry">
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <label for="editCantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="editCantidad" name="cantidad" min="2" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditarCantidadModal(idEventEntry) {
            $('#editarCantidadModal').modal('show');
            $('#editCantidadId').val(idEventEntry);
        }
    </script>

</body>

</html>
