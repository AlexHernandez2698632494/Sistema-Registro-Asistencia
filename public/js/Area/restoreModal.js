const openRestoreModal = (data) => {
    const elements = data.split(',');

    const areaId = elements[0];
    const areaName = elements[1];

    const message = `¿Está seguro que desea restaurar el festival "${areaName}"?`

    $('#txtRestoreModal').text(message);
    $('#txtIdAreaRestaurar').val(areaId);

    $('#restaurarArea').modal('show');
}