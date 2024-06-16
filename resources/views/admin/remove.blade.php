@extends('layout.header')


@section('title','Control de Administradores')

<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/admin/indexEInit.js') }}"></script>
<script src="{{ asset('js/admin/removedInit.js') }}"></script>
<script src="{{ asset('js/admin/restoreModal.js') }}"></script>
<script src="{{ asset('js/admin/deleteAdmin.js') }}"></script>
<body style="overflow-x: hidden">    

	@if (session('exitoRestaurar'))
        <script>
            swal({
                title: "Registro restaurado",
                text: "{{ session('exitoRestaurar') }}",
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

    @if (session('errorRestaurar'))
        <script>
            swal({
                title: "Error al restaurar",
                text: "{{ session('errorRestaurar') }}",
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
						<p style="color: black; margin: 0; font-weight: bold">Restauración de Administradores</p>
					</div>                                          
                </div>
            </nav>                         				
			<div class="card card-Teachers mx-5">
				<div class="card-body cardBody-Teachers">
					<p class="d-flex justify-content-center">Administradores eliminados</p>
					<div class="separator mb-3"></div>											
						<table class="table data-table table-striped" id="teachers-table">
							<thead class="table-head">
								<tr>
									<th scope="col">Nombre</th>
									<th scope="col">Apellido</th>
									<th scope="col">DUI</th>
									<th scope="col">Contacto</th>
									<th scope="col">Correo</th>
									<th scope="col">Acciones</th>
								</tr>
							</thead>
							<div class="table-body">
								<tbody>	
									@foreach ($removedAdmins as $removedadmin)
										<tr>
											<td>{{ $removedadmin->nombreAdmin }}</td>
											<td>{{ $removedadmin->apellidosAdmin }}</td>
                                            <td>{{ $removedadmin->carnetAdmin }}</td>	
                                            <td>{{ $removedadmin->telefonoAdmin}}</td>
                                            <td>{{ $removedadmin->correoAdmin}}</td>	
											<td>
												<div class="row d-flex justify-content-center">													
													<div class="col-4 mx-0 px-0">
														<button 
															type="button" 
															class="btn btn-success icon-button"
															data-bs-toggle="tooltip" 
															data-bs-placement="bottom" 
															data-bs-title="Restaurar" 
                                                            value="{{$removedadmin->idAdmin }}, {{$removedadmin->nombreAdmin.' '.$removedadmin->apellidosAdmin}}"
															onclick="openRestoreModal(this.value)">
															<i class="fa-solid fa-trash-can-arrow-up"></i>
														</button>
													</div>	
                                                    <div class="col-4 mx-0 px-0">
														<button 
															type="button" 
															class="btn btn-danger icon-button"
															data-bs-toggle="tooltip" 
															data-bs-placement="bottom" 
															data-bs-title="Eliminar" 
                                                            value="{{$removedadmin->idAdmin }}, {{$removedadmin->nombreAdmin.' '.$removedadmin->apellidosAdmin}}"
															onclick="openDeleteAdminModal(this.value)">
															<i class="fa-solid fa-trash""></i>
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
    <div class="modal fade" id="restaurarAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <form method="POST" action="{{ route('admin.restore')}}">
                        @csrf
                        @method('PUT')
                        <input type="text" name="idAdminRestaurar" id="txtIdAdminRestaurar" hidden>                        
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Restaurar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para eliminar definitivamente-->
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
                    <form method="POST" action="{{ route('admin.destroyer')}}">
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