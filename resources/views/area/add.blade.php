@extends('layout.header')

@section('title', 'Registro de Área')

<script src="{{ asset('js/sweetalert.js') }}"></script>
{{-- <script src="{{ asset('js/admin/addInit.js') }}"></script> --}}
<body >
    {{-- <script src="{{ asset('js/inactividad.js') }}"></script> --}}
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
                    <a href="{{ route('area.index') }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regresar">
                        <i class="fas fa-arrow-left"></i>
                    </a> 
                    <div class="col d-flex justify-content-center">
                        <p style="color: black; margin: 0; font-weight: bold">Registro de Áreas</p>
                    </div>
                </div>
            </nav>
            <div class="card mx-5">
                <div class="card-body">
                    <p class="d-flex justify-content-center">Ingreso
                        de información</p>
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
                    <form method="POST" action="{{ route('area.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-xs-12 mt-2">
                                <label for="txtNombreSeminarista" class="form-label"><b>Nombre</b></label>
                                <input type="text" id="txtNombreArea" name="nombreArea"
                                    placeholder="Ingrese nombre" class="form-control inputTxt"
                                    value="{{ old('nombreArea') }}" required>
                            </div>
                            <div class="col-lg-6 col-xs-12 mt-2">
                                <label for="txtEtapa" class="form-label"><b>Área</b></label>
                                <select class="form-select" aria-label="Default select example" id="tipoArea"
                                    name="tipoArea" onchange="getPhaseDuration(this.value)">
                                    <option value="0" selected>Seleccione una área </option>
                                     @foreach ($areas as $area)
                                        <option value={{ $area->idAreaFormativaEntretenimiento }}>{{ $area->nombreArea }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                                              
                        <div class="row mx-2 mt-5">
                            <div class="col d-flex justify-content-center">
                                <button type="submit" class="btn btn-block btn-Add">Registrar Área</button>                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>