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
        @include('layout.verticalMenuInvitadoPersonalUDB')
        <div id="content" class="mt-0 pt-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 mx-5">
                <div class="container-fluid">
                    <a href="{{ route('UDBStaffGuestSite.site') }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regresar">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="col text-center">
                        <p style="color: black; margin: 0; font-weight: bold">Adquirir entradas</p>
                    </div>
                </div>
            </nav>
            <div class="card mx-5 mb-3">
                <div class="card-body cardBody-Teachers">
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
                    <form id="entradaForm" method="POST" action="{{ route('UDBStaffGuestSite.addEntry') }}">
                        @csrf
                        <div class="row mx-1">
                            <div class="col-lg-6 col-xs-12">
                                <p style="margin-bottom: 0; font-weight: bold" class="mt-2">Nombre Completo</p>
                                <input type="text" id="nombre" name="nombre" placeholder="Ingrese su nombre y apellido" class="form-control input" required>
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <p style="margin-bottom: 0; font-weight: bold" class="mt-2">Sexo</p>
                                <select class="form-select" id="sexo" name="sexo" required>
                                    <option value="" disabled selected>Ingrese su género</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <p style="margin-bottom: 0; font-weight: bold" class="mt-2">Institución</p>
                                <input type="text" id="institucion" name="institucion" placeholder="Ingrese institución" class="form-control input" required>
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <p style="margin-bottom: 0; font-weight: bold" class="mt-2">Nivel Educativo</p>
                                <select class="form-select" id="nivel_educativo" name="nivel_educativo" required>
                                    <option value="" disabled selected>Ingrese su nivel académico</option>
                                    <option value="Parvularia">Parvularia</option>
                                    <option value="Básica">Básica</option>
                                    <option value="Tercer Ciclo">Tercer Ciclo</option>
                                    <option value="Bachillerato">Bachillerato</option>
                                    <option value="Universidad">Universidad</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mx-1 mt-3 d-flex justify-content-center">
                            <div class="col-lg-4">
                                <div class="btn-group d-flex justify-content-center">
                                    <button type="button" class="btn btn-primary mt-2 btn-block" onclick="ingresarDatos()">Ingresar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
 
            <div class="card mx-5">
                <div class="card-body">
                    <p class="d-flex justify-content-center">Tabla de Información</p>
                    <div class="separator mb-3"></div>
                    <table class="table table-striped" id="tablaInformacion">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Sexo</th>
                                <th scope="col">Institución</th>
                                <th scope="col">Nivel Educativo</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Se llenará dinámicamente -->
                        </tbody>
                    </table>
                    <div class="row mx-1 mt-3 d-flex justify-content-center">
                        <div class="col-lg-4">
                            <div class="btn-group d-flex justify-content-center">
                                <button type="button" class="btn btn-primary mt-2 btn-block" onclick="adquirirEntradas()">Adquirir Entradas</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    <script>
        function ingresarDatos() {
            const nombre = document.getElementById('nombre').value;
            const sexo = document.getElementById('sexo').value;
            const institucion = document.getElementById('institucion').value;
            const nivel_educativo = document.getElementById('nivel_educativo').value;
 
            if (nombre && sexo && institucion && nivel_educativo) {
                const tbody = document.querySelector('#tablaInformacion tbody');
                const row = document.createElement('tr');
 
                row.innerHTML = `
                    <td>${nombre}</td>
                    <td>${sexo}</td>
                    <td>${institucion}</td>
                    <td>${nivel_educativo}</td>
                    <td>
                        <button type="button" class="btn btn-warning icon-button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Actualizar"><i class="fa-solid fa-arrows-rotate" style="color: white"></i></button>
                        <button type="button" class="btn btn-danger icon-button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Eliminar"><i class="fa-solid fa-trash"></i></button>
                    </td>
                `;
 
                tbody.appendChild(row);
            }
        }
 
        function adquirirEntradas() {
            document.getElementById('entradaForm').submit();
        }
    </script>
</body>