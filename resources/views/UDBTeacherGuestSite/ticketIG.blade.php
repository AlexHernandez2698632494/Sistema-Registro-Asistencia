@extends('layout.header')


@section('title','Mi Perfil')

<script src="{{ asset('js/sweetalert.js') }}"></script>

<body style="overflow-x: hidden">    
	<script src="{{ asset('js/inactividad.js') }}"></script>
	@if (session('exitoModificar'))
        <script>
            swal({
                title: "Registro modificado",
                text: "{{ session('exitoModificar') }}",
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

    @if (session('errorModificar'))
        <script>
            swal({
                title: "Error al modificar",
                text: "{{ session('errorModificar') }}",
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
        @include('layout.verticalMenuInvitadoDocenteUDB')
        <div id="content" class="mt-0 pt-0">            
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 mx-5">
                <div class="container-fluid">                    
                    <a href="{{ route('UDBTeacherGuestSite.ticketI') }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regresar">
                        <i class="fas fa-arrow-left"></i>
                    </a>                    
                    <div class="col text-center">
                        <p style="color: black; margin: 0; font-weight: bold">Adquirir entradas</p>
                    </div>
                </div>
            </nav>    
            <div class="card mx-5 mb-3">
                <div class="card-body cardBody-Teachers text-center">
                    {{-- Botón de inscripción individual --}}
                    <a href="{{ route('UDBTeacherGuestSite.ticketI') }}" class="btn btn-primary mx-2">
                        Inscripción Individual
                    </a>
                   
                    {{-- Botón de inscripción grupal --}}
                    <a href="{{ route('UDBTeacherGuestSite.ticketG') }}" class="btn btn-secondary mx-2">
                        Inscripción Grupal
                    </a>
                </div>
            </div>  
        </div>
    </div>  
</body>
</html>