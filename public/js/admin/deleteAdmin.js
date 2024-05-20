const openDeleteAdminModal = ( value) =>{
    $('#eliminarAdmin').modal('show');

    const elements = value.split(',');

    const eventId = elements[0];
    const eventName = elements[1];

    const message = `¿Está seguro que desea eliminar el Administrador "${eventName}"?`;

    $('#txtIdAdminEliminar').val(eventId);
    $('#txtDeleteModal').text(message);
}