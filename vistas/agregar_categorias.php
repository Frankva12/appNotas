<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Libreria de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("form").submit(function(event) {
                event.preventDefault(); // Evitar el envío del formulario estándar
                var nombre = $("#nombre").val();
                var formData = {
                    nombre: nombre,
                };
                console.log(formData);
                $.ajax({
                    type: "POST",
                    url: "../conexion/agregar_categorias.php",
                    data: formData,
                    dataType: "json",
                    encode: true
                }).done(function(data) {
                    console.log(data);
                    if (data.status === "success") {
                        // Mostrar mensaje de éxito
                        mostrarMensaje("success", "¡Categoría agregada correctamente!");
                        // Limpiar el formulario después del éxito (opcional)
                        $("form")[0].reset();
                    } else {
                        // Mostrar mensaje de error
                        mostrarMensaje("danger", "Error al agregar categoría. Por favor, intenta nuevamente.");
                    }
                }).fail(function(data) {
                    console.log("Error en la solicitud AJAX");
                    // Mostrar mensaje de error
                    mostrarMensaje("danger", "Error en la solicitud AJAX. Por favor, intenta nuevamente.");
                });
            });

            // Función para mostrar mensajes
            function mostrarMensaje(tipo, mensaje) {
                // Limpiar mensajes anteriores
                $("#mensaje").empty();
                // Agregar el nuevo mensaje
                $("#mensaje").append('<div class="alert alert-' + tipo + ' alert-dismissible fade show" role="alert">' +
                    mensaje +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>');
            }
        });
    </script>
    <title>Agregar Categoría</title>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">Agregar Categoría</h1>
        <div class="row mt-4">
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-12">
                <div id="mensaje"></div> <!-- Elemento para mostrar mensajes -->
                <form>
                    <div class="form-group">
                        <label for="nombre">Nombre de la Categoría</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la Categoría" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block mt-3">Agregar Categoría</button>
                        <a href="categorias.php" class="btn btn-secondary btn-block mt-3">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
