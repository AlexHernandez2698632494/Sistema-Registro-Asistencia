// inactividad.js

var tiempoInactividad = 5 * 60 * 1000; // 10 minutos en milisegundos

function cerrarSesion() {
    
    window.location.href = '/logout'; 
}

function reiniciarTemporizador() {
    clearTimeout(temporizadorInactividad);
    temporizadorInactividad = setTimeout(cerrarSesion, tiempoInactividad);
}

document.addEventListener('mousemove', reiniciarTemporizador);
document.addEventListener('keypress', reiniciarTemporizador);

var temporizadorInactividad = setTimeout(cerrarSesion, tiempoInactividad);
