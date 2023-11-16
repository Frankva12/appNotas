$(document).ready(function() {
    $("form").submit(function(event) {
        event.preventDefault();

        var titulo = $("#titulo").val();
        var descripcion = $("#descripcion").val();
        var categoria = $("#categoria").val();
        var fecha = $("#fecha").val();

        if (titulo.length > 100) {
            mostrarMensaje("danger", "Error: El título no puede tener más de 100 caracteres.");
            return;
        }

        if (descripcion.length > 500) {
            mostrarMensaje("danger", "Error: La descripción no puede tener más de 500 caracteres.");
            return;
        }

        var formData = {
            usuarioId: usuarioId,
            titulo: titulo,
            descripcion: descripcion,
            categoria: categoria,
            fecha: fecha
        };

        console.log(formData);

        $.ajax({
            type: "POST",
            url: "../modelo/agregar_notas.php",
            data: formData,
            dataType: "json",
            encode: true
        }).done(function(data) {
            console.log(data);
            if (data.status === "success") {
                mostrarMensaje("success", "¡Nota agregada correctamente!");
                $("form")[0].reset();
            } else {
                mostrarMensaje("danger", "Error al agregar nota. Por favor, intenta nuevamente.");
            }
        }).fail(function(data) {
            console.log("Error en la solicitud AJAX");
            mostrarMensaje("danger", "Error en la solicitud AJAX. Por favor, intenta nuevamente.");
        });
    });

    function mostrarMensaje(tipo, mensaje) {
        $("#mensaje").empty();
        $("#mensaje").append('<div class="alert alert-' + tipo + ' alert-dismissible fade show" role="alert">' +
            mensaje +
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
            '</div>');
    }
});
