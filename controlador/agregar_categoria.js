$(document).ready(function() {
    $("form").submit(function(event) {
        event.preventDefault();

        var nombre = $("#nombre").val();
        if (nombre.length > 80) {
            mostrarMensaje("danger", "Error: El nombre de la categoría no puede tener más de 80 caracteres.");
            return;
        }

        var formData = {
            nombre: nombre,
        };

        console.log(formData);
        $.ajax({
            type: "POST",
            url: "../modelo/agregar_categorias.php",
            data: formData,
            dataType: "json",
            encode: true
        }).done(function(data) {
            console.log(data);
            if (data.status === "success") {
                mostrarMensaje("success", "¡Categoría agregada correctamente!");
                $("form")[0].reset();
            } else {
                mostrarMensaje("danger", "Error al agregar categoría. Por favor, intenta nuevamente.");
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