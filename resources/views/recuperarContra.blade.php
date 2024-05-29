@extends('layout.header')

@section('title', 'Recuperación de contraseña')

<script src="{{ asset('js/sweetalert.js') }}"></script>
{{-- #7facff --}}

<body>
    @if (session('errorSolicitud'))
        <script>
            swal({
                title: "Solicitud no realizada",
                text: "{{ session('errorSolicitud') }}",
                icon: "error",
                button: "OK",
            })
        </script>
    @endif
    <section class="vh-100" style="background-color: #0060B4;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <h3 class="mb-1">¡Bienvenido!</h3>
                            <h3 class="mb-3">Sistema de Registro de Asistencia DAC</h3>
                            <h5 class="mb-1">Recuperación de contraseña</h5>

                            <div class="my-4" style="background-color:#0060B4; height: 3px; border-radius: 2rem">
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger my-2 pb-0">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <p class="mb-1">Ingrese su nombre de usuario</p>
                            <form method="POST" action="{{ route('recuperarContra') }}">
                                @csrf
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa-solid fa-user"></i></span>
                                    <input type="text" class="form-control" placeholder="Usuario" aria-label="user"
                                        name="user">
                                </div>
                                <div class="row">
                                    <button class="btn btn-primary btn-lg btn-block mt-2"
                                        type="submit">Ingresar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</body>

</html>
