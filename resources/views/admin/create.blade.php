@extends('layout.header')


@section('title','Control de Administradores Eliminados')
<body>    
    @include('layout.horizontalMenu')    
    <div class="wrapper">
        @include('layout.verticalMenu')
        <div id="content" class="mt-0 pt-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 mx-5">
               <div class="container-fluid">
                  <div class="col">
                      <button type="button" id="sidebarCollapse" class="btn" style="background-color: #0D87C8">
                          <i class="fa-solid fa-bars" style="color: white"></i>                        
                      </button>  
                  </div>   
                  <div class="col">
                     <p style="color: black; margin: 0; font-weight: bold">Control de Administradores eliminados</p>
                  </div>                                          
               </div>
            </nav>
				<div class="card card-Teachers mx-5">
					<div class="card-body cardBody-Teachers">
						<p class="d-flex justify-content-center">Administradores Eliminados</p>
						<div class="separator mb-3"></div>											
							<table class="table data-table" id="teachers-table">
								<thead class="table-head">
									<tr>
										<th scope="col">Nombre</th>
										<th scope="col">Apellido</th>
										<th scope="col">DUI</th>
										<th scope="col">Contacto</th>
										<th scope="col">Correo</th>
										<th scope="col">Cargo</th>
										<th scope="col">Acciones</th>
										Mosttar registros: 
										Buscar:
									</tr>
								</thead>
								<div class="table-body">
									<tbody>	
										@foreach ($personas as $item)
										
											<tr>
												<td>{{$item->nombre}}</td>
												<td>{{$item->apellido}}</</td>
                        <td>{{$item->dui}}</</td>
												<td> {{$item->telefono}}</</td>
												<td>{{$item->correo}}</ </td>
												<td> </td>

												<td>
													<a type="button" class="btn btn-primary icon-button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Ver información" href=""><i class="fa-solid fa-magnifying-glass my-1"></i></a>
													<button type="button" class="btn btn-warning icon-button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Actualizar"><i class="fa-solid fa-arrows-rotate" style="color: white"></i></button>
													<button type="button" class="btn btn-danger icon-button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Eliminar"><i class="fa-solid fa-trash"></i></button>
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

</body>
</html>