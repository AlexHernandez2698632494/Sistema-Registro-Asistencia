const openDeleteAreaModal = ( value) =>{
    $('#eliminarArea').modal('show');

    const elements = value.split(',');

    const areaId = elements[0];
    const areaName = elements[1];

    const message = `¿Está seguro que desea eliminar el festival "${areaName}"?`;

    $('#txtIdAreaEliminar').val(areaId);
    $('#txtDeleteModal').text(message);
}