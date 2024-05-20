@extends('layout.header')


@section('title','Control de eventos')

<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/events/removedInit.js') }}"></script>
<script src="{{ asset('js/events/restoreModal.js') }}"></script>
<body style="overflow-x: hidden">    

	@if (session('exitoEliminar'))
        <script>
            swal({
                title: "Registro eliminado",
                text: "{{ session('exitoEliminar') }}",
                icon: "success",
                button: "OK",
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
            })            
        </script>
    @endif
    
    @if (session('exitoRestaurar'))
        <script>
            swal({
                title: "Registro restaurado",
                text: "{{ session('exitoRestaurar') }}",
                icon: "success",
                button: "OK",
            })            
        </script>
    @endif

    @if (session('errorRestaurar'))
        <script>
            swal({
                title: "Error al restaurar",
                text: "{{ session('errorRestaurar') }}",
                icon: "error",
                button: "OK",
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
						<p style="color: black; margin: 0; font-weight: bold">Restauración de eventos</p>
					</div>                                          
                </div>
            </nav>                         				
			<div class="card card-Teachers mx-5">
				<div class="card-body cardBody-Teachers">
					<p class="d-flex justify-content-center">Eventos eliminados</p>
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
									@foreach ($removedEvents as $removedEvents)
										<tr>
											<td>{{ $removedEvents->NombreEvento }}</td>
											<td>{{ $removedEvents->fecha }}</td>
                                            <td>{{ $removedEvents->hora }}</td>		
											<td>
												<div class="row d-flex justify-content-center">													
													<div class="col-4 mx-0 px-0">
														<button 
															type="button" 
															class="btn btn-success icon-button"
															data-bs-toggle="tooltip" 
															data-bs-placement="bottom" 
															data-bs-title="Restaurar" 
															value="{{$removedEvents->idEvento}}, {{$removedEvents->NombreEvento}}"
															onclick="openRestoreModal(this.value)">
															<i class="fa-solid fa-trash-can-arrow-up"></i>
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
	<!-- Modal para restaurar docentes-->
    <div class="modal fade" id="restaurarEvento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Verificación de restauración</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="txtRestoreModal"></p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('event.restore')}}">
                        @csrf
                        @method('PUT')
                        <input type="text" name="idEventoRestaurar" id="txtIdEventoRestaurar" hidden>                        
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Restaurar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>