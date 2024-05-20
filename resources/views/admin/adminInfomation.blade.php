@extends('layout.header')



@section('title','Información de administrador')

<body>   	
	<script src="{{ asset('js/inactividad.js') }}"></script>
    @include('layout.horizontalMenu')    
    <div class="wrapper">
        @include('layout.verticalMenu')
		
        <div id="content" class="mt-0 pt-0">             
			<nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 mx-5">
                <div class="container-fluid">                    
                    <a href="{{ route('admin.index') }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regresar">
                        <i class="fas fa-arrow-left"></i>
                    </a>                    
                    <div class="col text-center">
                        <p style="color: black; margin: 0; font-weight: bold">Información del administrador</p>
                    </div>
                </div>
            </nav>
			<div class="row">
				<div class="col-lg-4 col-xs-12">
					<div class="card">
						<div class="card-body">
							<p class="d-flex justify-content-center">Información general del administrador</p>
							<div class="separator"></div>	
							<div class="row mt-2">								
								<div class="col-12"><b>Nombre del administrador</b></div>
								<div class="col-12">{{$adminInfo->nombre}} {{$adminInfo->apellido}}</div>
							</div>
							<div class="row mt-2">								
								<div class="col-12"><b>DUI : </b></div>
								<div class="col-12">{{$adminInfo->dui}}</div>
							</div>
							<div class="row mt-2">								
								<div class="col-12"><b>Telefono: </b></div>
								<div class="col-12">{{$adminInfo->telefono}}</div>
							</div>
							<div class="row mt-2">								
								<div class="col-12"><b>Correo</b></div>
								<div class="col-12">{{$adminInfo->correo}}</div>
							</div>
							<div class="row mt-2">								
								<div class="col-12"><b>Direccion</b></div>
								<div class="col-12">{{$adminInfo->direccion}}</div>
							</div>
							
						</div>																					
					</div>  
				</div>				
			</div>    
		</div>                                                                            
    </div>
    
</body>

</html>
