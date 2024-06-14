@extends('layout.header')

@section('title', 'Información de evento')

<body>
    <script src="{{ asset('js/inactividad.js') }}"></script>
    @if (session('exito'))
        <script>
            swal({
                title: "Confirmacion ",
                text: "{{ session('exito') }}",
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

    @if (session('error'))
        <script>
            swal({
                title: "Error al adquirir",
                text: "{{ session('error') }}",
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
						<p style="color: black; margin: 0; font-weight: bold">Control de asistencias</p>
					</div>                                          
                </div>
            </nav>                         				
			<div class="card card-Teachers mx-5">
				<div class="card-body cardBody-Teachers">
					<p class="d-flex justify-content-center">Registro de asistencias</p>
					<div class="separator mb-3"></div>											
						<table class="table data-table table-striped" id="teachers-table">
							<thead class="table-head">
								<tr>
									<th>Nombre del Evento</th>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Nombre del Area</th>
                                            <th>Carrera/Profesion</th>
                                            <th>Capacidad</th>
                                            <th>Total de Registrados</th>
                                            <th>Total de Asistencia</th>
							</tr>
							</thead>
							<div class="table-body">
								<tbody>	
									@foreach ($records as $personalUDB)
									<tr>
										<td>{{ $personalUDB->nombreEvento }}</td>
                                                <td>{{ $personalUDB->fecha }}</td>
                                                <td>{{ $personalUDB->hora }}</td>
                                                <td>{{ $personalUDB->nombre }}</td>
                                                <td>{{ $personalUDB->profesionUDB}}</td>
                                                <td>{{ $personalUDB->capacidad}}</td>
                                                <td>{{ $personalUDB->total_registrados }}</td>
                                                <td>{{ $personalUDB->total_asistencia }}</td>
										</tr> 
									@endforeach
                                    @foreach ($recordsSUDB as $estudianteUDB)
									<tr>
										        <td>{{ $estudianteUDB->nombreEvento }}</td>
                                                <td>{{ $estudianteUDB->fecha }}</td>
                                                <td>{{ $estudianteUDB->hora }}</td>
                                                <td>{{ $estudianteUDB->nombre }}</td>
                                                <td>{{ $estudianteUDB->carreraUDB}}</td>
                                                <td>{{ $estudianteUDB->capacidad}}</td>
                                                <td>{{ $estudianteUDB->total_registrados }}</td>
                                                <td>{{ $estudianteUDB->total_asistencia }}</td>
										</tr> 
									@endforeach	
                                    @foreach ($recordsG as $personalUDB)
									<tr>
										<td>{{ $personalUDB->nombreEvento }}</td>
                                                <td>{{ $personalUDB->fecha }}</td>
                                                <td>{{ $personalUDB->hora }}</td>
                                                <td>{{ $personalUDB->nombre }}</td>
                                                <td>{{ $personalUDB->profesionUDB}}</td>
                                                <td>{{ $personalUDB->capacidad}}</td>
                                                <td>{{ $personalUDB->total_registrados }}</td>
                                                <td>{{ $personalUDB->total_asistencia }}</td>
										</tr> 
									@endforeach
                                    @foreach ($recordsSUDBG as $estudianteUDB)
									<tr>
										        <td>{{ $estudianteUDB->nombreEvento }}</td>
                                                <td>{{ $estudianteUDB->fecha }}</td>
                                                <td>{{ $estudianteUDB->hora }}</td>
                                                <td>{{ $estudianteUDB->nombre }}</td>
                                                <td>{{ $estudianteUDB->carreraUDB}}</td>
                                                <td>{{ $estudianteUDB->capacidad}}</td>
                                                <td>{{ $estudianteUDB->total_registrados }}</td>
                                                <td>{{ $estudianteUDB->total_asistencia }}</td>
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
