document.addEventListener("DOMContentLoaded", function(event) {  
    //Mostrando seleccion en el menú
    $('#controlAdministradores').addClass('selected-item');
    $('#registroAdministradores').removeClass('selected-item');
    $('#opcionesAdministradores').addClass('active');  
    $('#controlAdministradoresE').removeClass('selected-item');  

    var txtPhone = document.getElementById('txtTelefono');
    
    if(txtPhone != null) //Verificando  que exista un elemento con el id txtPhone
    {
        var maskOptions = {
            mask: '0000-0000'
        };
        var mask = IMask(txtPhone, maskOptions);
    }
})

const updateAdministradorModal = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://127.0.0.1:8000/admin/getAdmin/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
           const {idAdministrador, nombreAdministrador, apellidoAdministrador, duiAdministrador, telefonoAdministrador, correoAdministrador} = data;
            $('#txtNombreAdministrador').val(nombreAdministrador);
            $('#txtApellidoAdministrador').val(apellidoAdministrador);
            $('#txtDui').val(duiAdministrador);
            $('#txtTelefono').val(telefonoAdministrador);
            $('#txtCorreoAdministrador').val(correoAdministrador);
            $('#txtIdAdministradorActualizar').val(idAdministrador);
            
            $('#modificarAdministrador').modal('show');  
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

const confirmarEliminacion = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://127.0.0.1:8000/admin/getAdmin/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
           const {idAdministrador, nombreAdministrador, apellidoAdministrador, duiAdministrador, telefonoAdministrador, correoAdministrador} = data;
           const pregunta = "¿Está seguro que desea eliminar el administrador "+ nombreAdministrador+" "+apellidoAdministrador+"?";
           document.getElementById('txtPregunta').innerHTML=pregunta;
            $('#txtIdAdministradorEliminar').val(idAdministrador);
            
            $('#eliminarAdministrador').modal('show');  
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