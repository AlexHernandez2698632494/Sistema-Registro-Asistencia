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

    @if (session('info'))
        <script>
            swal({
                title: "Error al adquirir",
                text: "{{ session('info') }}",
                icon: "warning",
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
        @include('layout.verticalMenuInvitado')
        <div id="content" class="mt-0 pt-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 mx-5">
                <div class="container-fluid">
                    <a href="{{ route('viewEventLog.entry', ['id' => $evento->idEvento]) }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regresar">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="col text-center">
                        <p style="color: black; margin: 0; font-weight: bold">Adquirir entradas</p>
                    </div>
                </div>
            </nav>
            <div class="row mt-4 mx-5">
                <!-- Contenedor para agregar nueva persona -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Agregar Persona
                        </div>
                        <div class="card-body">
                            <form action="{{ route('storeEntries') }}" method="POST">
                                @csrf
                                <input type="hidden" name="idEvento" value="{{ $evento->idEvento }}">
                                <input type="hidden" name="idEventEntry" value="{{ $evento->idEventEntry }}"> <!-- Asegúrate de tener este valor -->
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="sexo" class="form-label">Sexo</label>
                                    <select class="form-control" id="sexo" name="sexo" required>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="nivel_educativo" class="form-label">Nivel Educativo</label>
                                    <input type="text" class="form-control" id="nivel_educativo" name="nivel_educativo" required>
                                </div>
                                <div class="mb-3">
                                    <label for="institucion" class="form-label">Institución</label>
                                    <input type="text" class="form-control" id="institucion" name="institucion" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Contenedor para mostrar los datos -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Información Guardada
                        </div>
                        <div class="card-body">
                            <ul>
                                <!-- Aquí iterar para mostrar las personas guardadas -->
                                @foreach ($personasComun as $persona)
                                    <li>
                                        <strong>Nombre:</strong> {{ $persona->nombre }}<br>
                                        <strong>Sexo:</strong> {{ $persona->sexo }}<br>
                                        <strong>Nivel Educativo:</strong> {{ $persona->nivel_educativo }}<br>
                                        <strong>Institución:</strong> {{ $persona->institucion }}<br>
                                    </li>
                                    <hr>
                                @endforeach
                                @foreach ($personasComunes as $persona)
                                    <li>
                                        <strong>Nombre:</strong> {{ $persona->nombre }}<br>
                                        <strong>Sexo:</strong> {{ $persona->sexo }}<br>
                                        <strong>Nivel Educativo:</strong> {{ $persona->nivel_educativo }}<br>
                                        <strong>Institución:</strong> {{ $persona->institucion }}<br>
                                    </li>
                                    <hr>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
