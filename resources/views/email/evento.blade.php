<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Evento</title>
</head>
<body>
    <h1>{{ $NombreEvento }}</h1>
    <p><strong>Lugar:</strong> {{ $Lugar }}</p>
    <p><strong>Fecha:</strong> {{ $Fecha }}</p>
    <p><strong>Hora:</strong> {{ $Hora }}</p>
    <p><strong>Descripción:</strong> {{ $Descripcion }}</p>
    <p><strong>Precio:</strong> {{ $Precio }}</p>
    <img src="{{ $Imagen }}" alt="Imagen del Evento {{ $NombreEvento }}">
</body>
</html>
