document.addEventListener("DOMContentLoaded", function(event) {    
    
    //Mostrando seleccion en el menú
    $('#solicitudesUsuarios').addClass('selected-item');
    $('#controlUsuarios').removeClass('selected-item');
    $('#opcionesUsuarios').addClass('active');   
});

const confirmarRestablecer = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://127.0.0.1:8000/user/getSolicitud/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
           const {idSolicitud, usuario} = data;
           const pregunta = "¿Está seguro que desea restablecer la contraseña al usuario "+ usuario+"?";
           document.getElementById('txtPregunta').innerHTML=pregunta;
            $('#txtIdUsuario').val(idSolicitud);
            
            $('#restablecerContra').modal('show');  
        },
    
        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto de la petición en crudo y código de estatus de la petición
        error : function(xhr, status) {
            // alert('Disculpe, existió un problema');
            swal({
                title: "Error",
                text: "Ha ocurrido un error al mostrar los datos, pongase en contacto con el administrador",
                icon: "error",
                button: "OK",
            })
        },       
    });
}