<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Bootstrap library -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var usuarioId = <?php echo isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 'null'; ?>;
        $(document).ready(function() {
            $("form").submit(function(event) {
                event.preventDefault(); // Prevent the standard form submission

                // Get the values from the inputs
                var titulo = $("#titulo").val();
                var descripcion = $("#descripcion").val();
                var categoria = $("#categoria").val();
                var fecha = $("#fecha").val();

                // Validate the title length
                if (titulo.length > 100) {
                    mostrarMensaje("danger", "Error: El título no puede tener más de 100 caracteres.");
                    return;
                }

                // Validate the description length
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
                    url: "../conexion/agregar_notas.php",
                    data: formData,
                    dataType: "json",
                    encode: true
                }).done(function(data) {
                    console.log(data);
                    if (data.status === "success") {
                        // Show success message
                        mostrarMensaje("success", "¡Nota agregada correctamente!");
                        // Clear the form after success (optional)
                        $("form")[0].reset();
                    } else {
                        // Show error message
                        mostrarMensaje("danger", "Error al agregar nota. Por favor, intenta nuevamente.");
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
    </script>

    <title>Agregar Nota</title>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">Agregar Nota</h1>
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-12">
                <div id="mensaje"></div> <!-- Elemento para mostrar mensajes -->
                <form>
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" id="titulo" placeholder="Título" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" rows="4" placeholder="Descripción" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoría</label>
                        <?php
                        include("../conexion/conexion.php");
                        $miConexion = new Conexion();
                        $query = "SELECT id, nombre_categoria FROM categorias";
                        $resultado = $miConexion->MostrarSQL($query);
                        ?>
                        <select class="form-control" id="categoria" name="categoria">
                            <?php
                            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $fila['id'] . "'>" . $fila['nombre_categoria'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="date" class="form-control" id="fecha" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block mt-3">Agregar Nota</button>
                        <a href="notas.php" class="btn btn-secondary btn-block mt-3">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
