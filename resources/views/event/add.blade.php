@extends('layout.header')

@section('title', 'Registro de eventos')

<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/events/initial.js') }}"></script>

<body>

    @if (session('exitoRegistro'))
        <script>
            swal({
                title: "Evento registrado",
                text: "Se registró correctamente el evento",
                icon: "success",
                button: "OK",
            });
        </script>
    @endif

    @if (session('errorRegistro'))
        <script>
            swal({
                title: "Error al registrar",
                text: "{{ session('errorRegistro') }}",
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
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3">
                <div class="container-fluid">                    
                    <a href="{{ route('events.index') }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regresar">
                        <i class="fas fa-arrow-left"></i>
                    </a>                    
                    <div class="col text-center">
                        <p style="color: black; margin: 0; font-weight: bold">Registro de nuevo evento</p>
                    </div>
                </div>
            </nav>  
            <div class="card eventAdd-Card">
                <div class="card-body">
                    <p class="d-flex justify-content-center">Registro de eventos</p>
                    <div class="separator"></div>
                    @if ($errors->any())
                        <div class="alert alert-danger my-2 pb-0">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{route('events.add')}}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-lg-5 col-xs-12">
                                <p class="d-flex justify-content-center mt-2 mb-0">Información general</p>
                                <p class="d-flex justify-content-center mt-0 subtitle">Ingrese la información que se solicita</p>
                                <div class="input-group mb-3 mt-3">
                                    <span class="input-group-text" id="eventName"><i class="fa-solid fa-person"></i></span>
                                    <input type="text" class="form-control" placeholder="Ingrese nombre del evento" aria-label="name" name="eventName" value="{{ old('eventName') }}">
                                </div>
                                <div class="input-group mb-3 mt-3">
                                    <span class="input-group-text" id="eventLocation"><i class="fa-solid fa-location-dot"></i></span>
                                    <input type="text" class="form-control" placeholder="Ingrese ubicación del evento" aria-label="Location" name="eventLocation" value="{{old('eventLocation')}}">
                                </div>
                                <div class="input-group mb-3 mt-3">
                                    <span class="input-group-text" id="eventDate"><i class="fa-solid fa-calendar"></i></span>
                                    <input type="date" class="form-control" placeholder="Ingrese fecha del evento" aria-label="Date" name="eventDate" value="{{old('eventDate')}}" min="{{ now()->toDateString() }}">
                                </div>
                                <div class="input-group mb-3 mt-3">
                                    <span class="input-group-text" id="eventTime"><i class="fa-solid fa-clock"></i></span>
                                    <input type="time" class="form-control" placeholder="Ingrese hora del evento" aria-label="Time" name="eventTime" value="{{old('eventTime')}}">
                                </div>
                                <div class="input-group mb-3 mt-3">
                                    <span class="input-group-text" id="eventDescription"><i class="fa-solid fa-info"></i></span>
                                    <input type="text" class="form-control" placeholder="Ingrese descripción o sinopsis del evento" aria-label="Description" name="eventDescription" value="{{old('eventDescription')}}">
                                </div>
                                <div class="input-group mb-3 mt-3">
                                    <span class="input-group-text" id="eventPrice"><i class="fa-solid fa-money-bill"></i></span>
                                    <input type="price" class="form-control" placeholder="Ingrese precio del evento" aria-label="Price" name="eventPrice" value="{{old('eventPrice')}}">
                                </div>
                                <div class="input-group mb-3 mt-3">
                                    <span class="input-group-text" id="eventImage"><i class="fa-solid fa-image"></i></span>
                                    <input type="file" class="form-control" placeholder="Ingrese imagen promocional" aria-label="Image" name="eventImage" accept="image/jpeg, image/jpg, image/png">
                                </div>
                                <div class="input-group mb-3 mt-3">
                                    <span class="input-group-text" id="eventCapacity"><i class="fa-solid fa-users"></i></span>
                                    <input type="number" class="form-control" placeholder="Ingrese capacidad del evento" aria-label="Capacity" name="eventCapacity" min="1" value="{{old('eventCapacity')}}">
                                </div>
                            </div>
                            <div class="col-lg-7 col-xs-12 subjects-container">
                                <p class="d-flex justify-content-center mt-2 mb-0">Seleccione el área del evento</p>
                                <div class="row">
                                    @if ($formativa->isNotEmpty())
                                        <p class="d-flex justify-content-center mt-0">{{ $formativa->first()->nombreArea }}</p>
                                        @foreach ($formativa as $area)
                                            <div class="col-lg-4 col-xs-12 ">
                                                <div class="form-check mt-3">
                                                    <input class="form-check-input" type="checkbox" value="{{ $area->idAreas }}" id="checkSubject{{ $area->idAreas }}" name="areas[]" {{ in_array($area->idAreas, old('areas', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="checkSubject{{ $area->idAreas }}">
                                                        {{ $area->nombre }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <br>
                                <div class="separator"></div><br>
                                <div class="row">
                                    @if($entretenimiento->isNotEmpty())
                                    <p class="d-flex justify-content-center mt-0">{{ $entretenimiento->first()->nombreArea }}</p>
                                    @foreach ($entretenimiento as $area)
                                        <div class="col-lg-4 col-xs-12 ">
                                            <div class="form-check mt-3">
                                                <input class="form-check-input" type="checkbox" value="{{ $area->idAreas }}" id="checkSubject{{ $area->idAreas }}" name="areas[]" {{ in_array($area->idAreas, old('areas', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="checkSubject{{ $area->idAreas }}">
                                                    {{ $area->nombre }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mx-2 my-2">
                            <div class="col d-flex justify-content-center">
                                <button type="submit" class="btn btn-block btn-Add">Registrar evento</button>
                            </div>								
                        </div> 
                    </form>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
