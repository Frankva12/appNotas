$(document).ready(function() {
    $("form").submit(function(event) {
        event.preventDefault();
        var usuario = $("#usuario").val();
        var contrasenia = $("#contrasenia").val();
        var privilegio = $("#privilegio").val();
        var nombre = $("#nombre").val();

        if (nombre.length > 80) {
            mostrarMensaje("danger", "Error: El nombre no puede tener más de 80 caracteres.");
            return;
        }

        if (usuario.length > 30) {
            mostrarMensaje("danger", "Error: El usuario no puede tener más de 30 caracteres.");
            return;
        }

        if (contrasenia.length < 8) {
            mostrarMensaje("danger", "Error: La contraseña debe tener al menos 8 caracteres.");
            return;
        }

        var formData = {
            usuario: usuario,
            contrasenia: contrasenia,
            privilegio: privilegio,
            nombre: nombre,
        };

        $.ajax({
            type: "POST",
            url: "../modelo/agregar_usuarios.php",
            data: formData,
            dataType: "json",
            encode: true
        }).done(function(data) {
            if (data.status === "success") {
                mostrarMensaje("success", "¡Usuario agregado correctamente!");
                $("form")[0].reset();
            } else {
                mostrarMensaje("danger", "Error al agregar usuario. Por favor, intenta nuevamente.");
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