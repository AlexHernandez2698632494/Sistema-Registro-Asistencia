const openRestoreModal = (data) => {
    const elements = data.split(',');

    const eventId = elements[0];
    const eventName = elements[1];

    const message = `¿Está seguro que desea restaurar el administrador "${eventName}"?`

    $('#txtRestoreModal').text(message);
    $('#txtIdAdminRestaurar').val(eventId);

    $('#restaurarAdmin').modal('show');
}