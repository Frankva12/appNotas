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

    $(".eliminar-nota").click(function () {
        var idNota = $(this).data("id");
        if (confirm("¿Estás seguro de que deseas eliminar esta nota?")) {
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
                if (data.status === "success") {
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

function editarNota() {
    var id = $("#idNotaEditar").val();
    var nuevoTitulo = $("#tituloNota").val();
    var nuevaDescripcion = $("#descripcionNota").val();
    var nuevaCategoria = $("#categoriaNota").val();
    var nuevaFecha = $("#fechaNota").val();

    if (nuevoTitulo.length === 0 || nuevoTitulo.length > 100) {
        alert('Error: El título debe tener entre 1 y 100 caracteres.');
        return;
    }
    $.ajax({
        url: '../modelo/editar_nota.php',
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
                window.location.href = 'notas.php?mensaje=success_update';
            } else {
                alert('Error al editar la nota.');
            }
        }
    });
}