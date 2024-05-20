document.addEventListener("DOMContentLoaded", function(event) {  
    //Mostrando seleccion en el menú
    $('#registroAdministradores').addClass('selected-item');
    $('#controlAdministradores').removeClass('selected-item');
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

    var txtDui = document.getElementById('txtDui');
    
    if(txtDui != null) //Verificando  que exista un elemento con el id txtPhone
    {
        var maskOptions = {
            mask: '00000000-0'
        };
        var mask = IMask(txtDui, maskOptions);
    }
})