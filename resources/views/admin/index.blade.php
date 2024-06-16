@extends('layout.header')


@section('title', 'Control de Admins')

<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/admin/indexInit.js') }}"></script>
<script src="{{ asset('js/admin/deleteAdmin.js') }}"></script>

<body style="overflow-x: hidden">
    <script src="{{ asset('js/inactividad.js') }}"></script>
    @if (session('exitoEliminacion'))
        <script>
            swal({
                title: "Admin eliminado",
                text: "{{ session('exitoEliminacion') }}",
                icon: "success",
                button: "OK",
                closeOnClickOutside: false,
            }).then((value) => {
                if (value) {
                    location.reload();
                }
            });
        </script>
    @endif

    @if (session('errorEliminacion'))
        <script>
            swal({
                title: "Error al eliminar",
                text: "{{ session('errorEliminacion') }}",
                icon: "error",
                button: "OK",
                closeOnClickOutside: false,
            }).then((value) => {
                if (value) {
                    location.reload();
                }
            });
        </script>
    @endif

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
                title: "Error al registrar",
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
        @include('layout.verticalMenu')
        <div id="content" class="mt-0 pt-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 mx-5">
                <div class="container-fluid">
                    <div class="col d-flex justify-content-center">
                        <p style="color: black; margin: 0; font-weight: bold">Control de administradores</p>
                    </div>
                </div>
            </nav>
            <div class="card card-Admins mx-5">
                <div class="card-body cardBody-Admins">
                    <p class="d-flex justify-content-center">Administradores registrados</p>
                    <div class="separator mb-3"></div>
                    <table class="table data-table table-striped" id="admins-table">
                        <thead class="table-head">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Carnet</th>
                                <th scope="col">Contacto</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <div class="table-body">
                            <tbody>
                                @foreach ($admin as $item)
                                    <tr>
                                        <td>{{ $item->nombreAdmin }}</td>
                                        <td>{{ $item->apellidosAdmin }}</td>
                                        <td>{{ $item->carnetAdmin }}</td>
                                        <td> {{ $item->telefonoAdmin }}</td>
                                        <td>{{ $item->correoAdmin }} </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-4 mx-0 px-0">
                                                    <a type="button" class="btn btn-primary icon-button"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-title="Ver información"
                                                        href="{{ route('admin.adminInfo', $item->idAdmin) }}"><i
                                                            class="fa-solid fa-eye my-1"></i></a>
                                                </div>
                                                <div class="col-4 mx-0 px-0">
                                                    <a type="button" class="btn btn-warning icon-button"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-title="Actualizar"
                                                        href="{{ route('admin.edit', $item->idAdmin) }}"><i
                                                            class="fa-solid fa-arrows-rotate my-1"
                                                            style="color: white"></i></a>
                                                </div>
                                                <div class="col-4 mx-0 px-0">
                                                    <button type="button" class="btn btn-danger icon-button"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-title="Eliminar"
                                                        value="{{$item->idAdmin }}, {{$item->nombreAdmin.' '.$item->apellidosAdmin}}"
                                                        onclick="openDeleteAdminModal(this.value)">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Modal para eliminar docente-->
    <div class="modal fade" id="eliminarAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Verificación de eliminación</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="txtDeleteModal"></p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('admin.delete') }}">
                        @csrf
                        @method('DELETE')
                        <input type="text" name="idAdminEliminar" id="txtIdAdminEliminar" hidden>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
