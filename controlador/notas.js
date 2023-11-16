$(document).ready(function () {
    $(".btn-info").click(function () {
        var idNota = $(this).data("id");
        var titulo = $(this).data("titulo");
        var descripcion = $(this).data("descripcion");
        var fecha = $(this).data("fecha");

        $("#idNotaEditar").val(idNota);
        $("#tituloNota").val(titulo);
        $("#descripcionNota").val(descripcion);
        $("#fechaNota").val(fecha);

        $("#editarNotaModal").modal("show");
    });

    // Al hacer clic en el botón de eliminar
    $(".eliminar-nota").click(function () {
        var idNota = $(this).data("id");

        // Confirmar la eliminación
        if (confirm("¿Estás seguro de que deseas eliminar esta nota?")) {
            // Realizar la petición AJAX para cambiar el estado de la nota
            $.ajax({
                type: "POST",
                url: "../modelo/cambiar_estado_nota.php",
                data: {
                    id: idNota,
                    estado: 0
                },
                dataType: "json",
                encode: true
            }).done(function (data) {
                // Recargar la página después de la eliminación exitosa
                if (data.status === "success") {
                    // Redirigir a la página de notas con un mensaje de éxito
                    window.location.href = 'notas.php?mensaje=success_delete';
                } else {
                    console.log("Error al cambiar el estado de la nota");
                }
            }).fail(function (data) {
                console.log("Error en la solicitud AJAX");
            });
        }
    });
});

// Función para enviar la solicitud de edición de nota
function editarNota() {
    var id = $("#idNotaEditar").val();
    var nuevoTitulo = $("#tituloNota").val();
    var nuevaDescripcion = $("#descripcionNota").val();
    var nuevaCategoria = $("#categoriaNota").val();
    var nuevaFecha = $("#fechaNota").val();

    // Validar campos
    if (nuevoTitulo.length === 0 || nuevoTitulo.length > 100) {
        alert('Error: El título debe tener entre 1 y 100 caracteres.');
        return;
    }
    // Realizar la solicitud AJAX para editar la nota
    $.ajax({
        url: '../modelo/editar_nota.php', // Reemplaza con el nombre de tu archivo de edición de nota
        type: 'POST',
        data: {
            id: id,
            nuevoTitulo: nuevoTitulo,
            nuevaDescripcion: nuevaDescripcion,
            nuevaCategoria: nuevaCategoria,
            nuevaFecha: nuevaFecha,
        },
        success: function (response) {
            if (response === 'success') {
                // Redirigir a la página de notas con un mensaje de éxito
                window.location.href = 'notas.php?mensaje=success_update';
            } else {
                alert('Error al editar la nota.');
            }
        }
    });
}