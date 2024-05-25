$(document).ready(function () {  
    //Iniciando máscara para campos de texto
    var txtPhone = document.getElementById('txtPhone');
    
    if(txtPhone != null) //Verificando  que exista un elemento con el id txtPhone
    {
        var maskOptions = {
            mask: '0000-0000'
        };
        var mask = IMask(txtPhone, maskOptions);
    }

    //Iniciando máscara para campos de dui

    var txtDui = document.getElementById('txtDui');
    
    if(txtDui != null) //Verificando  que exista un elemento con el id txtPhone
    {
        var maskOptions = {
            mask: '00000000-0'
        };
        var mask = IMask(txtDui, maskOptions);
    }

    //Iniciando máscara para campos de carnetAdministrador

    var txtCarnetAdmin = document.getElementById('txtCarnetAdmin');
    
    if(txtCarnetAdmin != null) //Verificando  que exista un elemento con el id txtPhone
    {
        var maskOptions = {
            mask: 'L0000',  // L representa una letra del abecedario (A-Z)
            definitions: {
                'L': /[A-Z]/,
            }
        };
        var mask = IMask(txtCarnetAdmin, maskOptions);
    }

    //Iniciando máscara para campos de carnetEstudianteUDB

    var txtCarnetEstudianteUDB = document.getElementById('txtCarnetEstudianteUDB');
    
    if(txtCarnetEstudianteUDB != null) //Verificando  que exista un elemento con el id txtPhone
    {
        var maskOptions = {
            mask: 'LL000000',  // L representa una letra del abecedario (A-Z)
            definitions: {
                'L': /[A-Z]/,
            }
        };
        var mask = IMask(txtCarnetEstudianteUDB, maskOptions);
    }
    
    
});