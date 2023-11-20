// Función para abrir el modal de edición
function abrirModalEditar(id, nombre) {
    $('#idCategoriaEditar').val(id);
    $('#nombreCategoria').val(nombre);
    $('#editarCategoriaModal').modal('show');
}

// Función para validar la longitud del nombre de la categoría
function editarCategoria() {
    var nuevoNombre = $('#nombreCategoria').val();

    if (nuevoNombre.length > 80) {
        alert("Error: El nombre de la categoría no puede tener más de 80 caracteres.");
        return false;
    }

    var id = $('#idCategoriaEditar').val();
    var nuevoNombre = $('#nombreCategoria').val();

    $.ajax({
        url: '../modelo/editar_categoria.php', 
        type: 'POST',
        data: {
            id: id,
            nuevoNombre: nuevoNombre
        },
        success: function (response) {
            if (response === 'success') {
                location.reload();
            } else {
                alert('Error al editar la categoría.');
            }
        }
    });
}
