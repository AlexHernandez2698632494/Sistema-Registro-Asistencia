document.addEventListener("DOMContentLoaded", function(event) {    
    
    //Mostrando seleccion en el menú
    $('#controlUsuarios').addClass('selected-item');
    $('#opcionesUsuarios').addClass('active');   
    $('#solicitudesUsuarios').removeClass('selected-item');
});

const confirmarEliminacion = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://127.0.0.1:8000/user/getUser/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
           const {idUsuario, usuario} = data;
           const pregunta = "¿Está seguro que desea eliminar el usuario "+ usuario+"?";
           document.getElementById('txtPregunta').innerHTML=pregunta;
            $('#txtIdUsuarioEliminar').val(idUsuario);
            
            $('#eliminarUsuario').modal('show');  
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