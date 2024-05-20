document.addEventListener("DOMContentLoaded", function(event) {  
    //Mostrando seleccion en el menú
    $('#controlAdministradoresE').addClass('selected-item');
    $('#controlAdministradores').removeClass('selected-item');
    $('#registroAdministradores').removeClass('selected-item');
    $('#opcionesAdministradores').addClass('active');    

    var txtPhone = document.getElementById('txtTelefono');
    
    if(txtPhone != null) //Verificando  que exista un elemento con el id txtPhone
    {
        var maskOptions = {
            mask: '0000-0000'
        };
        var mask = IMask(txtPhone, maskOptions);
    }
})

const openRestoreModal = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://127.0.0.1:8000/admin/getAdmin/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
           const {idAdministrador, nombreAdministrador, apellidoAdministrador, duiAdministrador, telefonoAdministrador, correoAdministrador} = data;
           const pregunta = "¿Está seguro que desea restaurar el administrador "+ nombreAdministrador+" "+apellidoAdministrador+"?";
           document.getElementById('txtPregunta').innerHTML=pregunta;
            $('#txtIdAdministradorRestaurar').val(idAdministrador);
            
            $('#restaurarAdministrador').modal('show');  
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