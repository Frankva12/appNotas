$(document).ready(function() {
    $("form").submit(function(event) {
        event.preventDefault(); // Prevent the standard form submission

        // Get the value from the input
        var nombre = $("#nombre").val();

        // Validate the length of the category name
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
                // Show success message
                mostrarMensaje("success", "¡Categoría agregada correctamente!");
                // Clear the form after success (optional)
                $("form")[0].reset();
            } else {
                // Show error message
                mostrarMensaje("danger", "Error al agregar categoría. Por favor, intenta nuevamente.");
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