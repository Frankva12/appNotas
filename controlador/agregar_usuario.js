$(document).ready(function() {
    $("form").submit(function(event) {
        event.preventDefault(); // Prevent the standard form submission
        var usuario = $("#usuario").val();
        var contrasenia = $("#contrasenia").val();
        var privilegio = $("#privilegio").val(); // Get the value from the combobox
        var nombre = $("#nombre").val();

        // Validate Nombre (Name)
        if (nombre.length > 80) {
            mostrarMensaje("danger", "Error: El nombre no puede tener más de 80 caracteres.");
            return;
        }

        // Validate Usuario (Username)
        if (usuario.length > 30) {
            mostrarMensaje("danger", "Error: El usuario no puede tener más de 30 caracteres.");
            return;
        }

        // Validate Contraseña (Password)
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

        // Perform AJAX request
        $.ajax({
            type: "POST",
            url: "../modelo/agregar_usuarios.php",
            data: formData,
            dataType: "json",
            encode: true
        }).done(function(data) {
            if (data.status === "success") {
                // Show success message
                mostrarMensaje("success", "¡Usuario agregado correctamente!");
                // Clear the form after success (optional)
                $("form")[0].reset();
            } else {
                // Show error message
                mostrarMensaje("danger", "Error al agregar usuario. Por favor, intenta nuevamente.");
            }
        }).fail(function(data) {
            console.log("Error en la solicitud AJAX");
            // Show error message
            mostrarMensaje("danger", "Error en la solicitud AJAX. Por favor, intenta nuevamente.");
        });
    });

    // Function to display messages
    function mostrarMensaje(tipo, mensaje) {
        // Clear previous messages
        $("#mensaje").empty();
        // Add the new message
        $("#mensaje").append('<div class="alert alert-' + tipo + ' alert-dismissible fade show" role="alert">' +
            mensaje +
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
            '</div>');
    }
});