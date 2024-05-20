@extends('layout.header')


@section('title','Control de eventos')

<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/events/deleteEvents.js') }}"></script>

<body style="overflow-x: hidden">  
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

	@if (session('exitoEliminacion'))
        <script>
            swal({
                title: "Evento eliminado",
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

    @include('layout.horizontalMenu')    
    <div class="wrapper">
        @include('layout.verticalMenu')
        <div id="content" class="mt-0 pt-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 mx-5">
                <div class="container-fluid">					  
					<div class="col d-flex justify-content-center">
						<p style="color: black; margin: 0; font-weight: bold">Control de eventos</p>
					</div>                                          
                </div>
            </nav>                         				
			<div class="card card-Teachers mx-5">
				<div class="card-body cardBody-Teachers">
					<p class="d-flex justify-content-center">Eventos registrados</p>
					<div class="separator mb-3"></div>											
						<table class="table data-table table-striped" id="teachers-table">
							<thead class="table-head">
								<tr>
									<th scope="col">Nombre</th>
									<th scope="col">Fecha</th>
									<th scope="col">Hora</th>
									<th scope="col">Acciones</th>
							</tr>
							</thead>
							<div class="table-body">
								<tbody>	
									@foreach ($events as $event)
									<tr>
										<td>{{ $event->NombreEvento}}</td>
										<td>{{ $event->fecha }}</td>
										<td>{{ $event->hora }}</td>
								<td>
												<div class="row">
													<div class="col-4 mx-0 px-0">
														<a type="button" class="btn btn-primary icon-button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Ver información" href="{{ route('events.showInfo', $event->idEvento) }}"><i class="fa-solid fa-eye my-1"></i></a>
													</div>
													<div class="col-4 mx-0 px-0">
														<a type="button" class="btn btn-warning icon-button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Actualizar" href="{{ route('events.edit', $event->idEvento)}}"><i class="fa-solid fa-arrows-rotate my-1" style="color: white"></i></a>
													</div>
													<div class="col-4 mx-0 px-0">
														<button 
															type="button" 
															class="btn btn-danger icon-button"
															data-bs-toggle="tooltip" 
															data-bs-placement="bottom" 
															data-bs-title="Eliminar" 
															value="{{$event->idEvento}}, {{$event->NombreEvento}}"
															onclick="openDeleteEventModal(this.value)">
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
    <div class="modal fade" id="eliminarEvento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <form method="POST" action="{{ route('events.delete')}}">
                        @csrf
                        @method('DELETE')
                        <input type="text" name="idEventoEliminar" id="txtIdEventoEliminar" hidden>                        
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>