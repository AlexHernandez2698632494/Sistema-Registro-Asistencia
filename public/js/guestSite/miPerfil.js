document.addEventListener("DOMContentLoaded", function(event) {    

    //Mostrando selección de vista en menú  
    $('#opcionesMiPerfil').addClass('active');

    var txtCellPhone = document.getElementById('txtTelefonoInvitado');
    
    if(txtCellPhone != null) //Verificando  que exista un elemento con el id txtPhone
    {
        var maskOptions = {
            mask: '0000-0000'
        };
        var mask = IMask(txtCellPhone, maskOptions);
    }
})

const updateInformacionModal = (id) => {
    $('#modificarInformacion').modal('show');
}