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

    // Puedes realizar otras validaciones si es necesario

    return true;
}