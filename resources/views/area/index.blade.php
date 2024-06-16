@extends('layout.header')


@section('title', 'Control de Áreas')

<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/Area/indexInit.js') }}"></script>
<script src="{{ asset('js/Area/deleteArea.js') }}"></script>

<body style="overflow-x: hidden">
    <script src="{{ asset('js/inactividad.js') }}"></script>
    

    @if (session('exitoEliminar'))
        <script>
            swal({
                title: "Registro eliminado",
                text: "{{ session('exitoEliminar') }}",
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

    @if (session('errorEliminar'))
        <script>
            swal({
                title: "Error al eliminar",
                text: "{{ session('errorEliminar') }}",
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
                        <p style="color: black; margin: 0; font-weight: bold">Control de Áreas</p>
                    </div>
                </div>
            </nav>
            <div class="card card-Teachers mt-3 mx-5">
                <div class="card-body cardBody-Teachers">
                    <p class="d-flex justify-content-center">Festivales registrados</p>
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
                    <table class="table data-table table-striped" id="teachers-table">
                        <thead class="table-head">
                            <tr>
                                <th scope="col" hidden>Nivel</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Área</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <div class="table-body">
                            <tbody>
                                @foreach ($trainingEntertainment as $trainingEntertainment)
                                    <tr>
                                        <td hidden>{{$trainingEntertainment->nivel}}</td>
                                        <td>{{ $trainingEntertainment->nombre }}</td>
                                        <td>{{ $trainingEntertainment->nombreArea}}</td>
                                        <td>
                                            <div class="row">
                                                <div class="row">
                                                    <div class="col-4 mx-0 px-0">
                                                        <button 
                                                            type="button" 
                                                            class="btn btn-danger icon-button"
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="bottom" 
                                                            data-bs-title="Eliminar" 
                                                             value="{{$trainingEntertainment->idAreas}}, {{$trainingEntertainment->nombre}}"
                                                            onclick="openDeleteAreaModal(this.value)">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
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
    <div class="modal fade" id="eliminarArea" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <form method="POST" action="{{ route('area.delete')}}">
                        @csrf
                        @method('DELETE')
                        <input type="text" name="idAreaEliminar" id="txtIdAreaEliminar" hidden>                        
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
