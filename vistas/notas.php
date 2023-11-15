<?php
session_start(); // Iniciar sesión

// Llamado a la clase de conexión
include("../conexion/conexion.php");

// Crear una instancia de la clase conexión
$conn = new conexion();

// Obtener el ID del usuario en sesión
$idUsuario = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 0;

// Establecer consulta de selección a la tabla notas
$sql = "SELECT n.id, u.usuario, n.titulo, n.descripcion, c.nombre_categoria, n.fecha, n.estado 
        FROM notas n 
        INNER JOIN usuarios u ON n.id_usuario = u.id 
        INNER JOIN categorias c ON n.categoria_id = c.id 
        WHERE n.estado = 1 AND n.id_usuario = :idUsuario;";

// Preparar la consulta SQL
$stmt = $conn->pdo()->prepare($sql);

// Asociar el parámetro ID del usuario en sesión a la consulta
$stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

// Ejecutar la consulta SQL
$stmt->execute();

// Obtener los resultados
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

function getCardClass($noteDate)
{
    $currentDate = date("Y-m-d");
    return ($noteDate < $currentDate) ? "bg-warning" : "bg-primary";
}

// Obtener las categorías
$queryCategorias = "SELECT id, nombre_categoria FROM categorias";
$resultadoCategorias = $conn->pdo()->query($queryCategorias);
$categorias = $resultadoCategorias->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Notas</title>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="text-center">Mis Notas</h1>
            <a href="agregar_notas.php" class="btn btn-primary mt-3">Agregar Nota</a>
            <a href="categorias.php" class="btn btn-secondary mt-3">Categorias</a>

            <?php
            // Obtener el tipo de usuario desde la sesión
            $tipoUsuario = isset($_SESSION['usuario_privilegio']) ? $_SESSION['usuario_privilegio'] : '';

            // Mostrar el botón de usuarios solo si el usuario es administrador
            if ($tipoUsuario === 'administrador') {
                echo '<a href="usuarios.php" class="btn btn-info mt-3">Usuarios</a>';
            }
            ?>
            <a href="papelera.php" class="btn btn-warning mt-3">Papelera</a>
            <a href="../conexion/cerrar_session.php" class="btn btn-danger mt-3">Cerrar Sesión</a>
        </div>
        <div class="row mt-4">
            <?php foreach ($res as $row) { ?>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card <?php echo getCardClass($row['fecha']); ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $row['titulo']; ?></h5>
                            <p class="card-text"><?php echo $row['descripcion']; ?></p>
                            <p class="card-text"><strong>Categoría:</strong> <?php echo $row['nombre_categoria']; ?></p>
                            <p class="card-text"><strong>Fecha:</strong> <?php echo $row['fecha']; ?></p>
                            <button class="btn btn-info mx-2" data-toggle="modal" data-target="#editarNotaModal" data-id="<?php echo $row['id']; ?>" data-titulo="<?php echo $row['titulo']; ?>" data-descripcion="<?php echo $row['descripcion']; ?>" data-categoria-nota="<?php echo $row['id']; ?>" data-categoria-nombre="<?php echo $row['nombre_categoria']; ?>" data-fecha="<?php echo $row['fecha']; ?>">
                                <i class="fa fa-pencil"></i> Editar
                            </button>


                            <button class="btn btn-danger mx-2 eliminar-nota" data-id="<?php echo $row['id']; ?>">
                                <i class="fa fa-trash"></i> Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Modal para editar nota -->
    <div class="modal fade" id="editarNotaModal" tabindex="-1" role="dialog" aria-labelledby="editarNotaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarNotaModalLabel">Editar Nota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formularioEditarNota">
                        <div class="form-group">
                            <label for="tituloNota">Título:</label>
                            <input type="text" class="form-control" id="tituloNota" name="tituloNota" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcionNota">Descripción:</label>
                            <textarea class="form-control" id="descripcionNota" name="descripcionNota" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="categoriaNota">Categoría:</label>
                            <select class="form-control" id="categoriaNota" name="categoriaNota" required>
                                <?php foreach ($categorias as $categoria) : ?>
                                    <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre_categoria']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="fechaNota">Fecha:</label>
                            <input type="date" class="form-control" id="fechaNota" name="fechaNota" required>
                        </div>
                        <input type="hidden" id="idNotaEditar" name="idNotaEditar">
                        <button type="button" class="btn btn-primary" onclick="editarNota()">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".btn-info").click(function() {
                var idNota = $(this).data("id");
                var titulo = $(this).data("titulo");
                var descripcion = $(this).data("descripcion");
                var categoria = $(this).data("categoria-nota");
                var fecha = $(this).data("fecha");

                // Verificar si la categoría está definida antes de asignarla
                categoria = (categoria !== undefined) ? categoria : '';

                $("#idNotaEditar").val(idNota);
                $("#tituloNota").val(titulo);
                $("#descripcionNota").val(descripcion);

                // Set the selected category in the dropdown
                $("#categoriaNota").val(categoria);

                $("#fechaNota").val(fecha);

                $("#editarNotaModal").modal("show");
            });

            // Al hacer clic en el botón de eliminar
            $(".eliminar-nota").click(function() {
                var idNota = $(this).data("id");

                // Confirmar la eliminación
                if (confirm("¿Estás seguro de que deseas eliminar esta nota?")) {
                    // Realizar la petición AJAX para cambiar el estado de la nota
                    $.ajax({
                        type: "POST",
                        url: "../conexion/cambiar_estado_nota.php",
                        data: {
                            id: idNota,
                            estado: 0
                        },
                        dataType: "json",
                        encode: true
                    }).done(function(data) {
                        // Recargar la página después de la eliminación exitosa
                        if (data.status === "success") {
                            location.reload();
                        } else {
                            console.log("Error al cambiar el estado de la nota");
                        }
                    }).fail(function(data) {
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

            // Realizar la solicitud AJAX para editar la nota
            $.ajax({
                url: '../conexion/editar_nota.php', // Reemplaza con el nombre de tu archivo de edición de nota
                type: 'POST',
                data: {
                    id: id,
                    nuevoTitulo: nuevoTitulo,
                    nuevaDescripcion: nuevaDescripcion,
                    nuevaCategoria: nuevaCategoria,
                    nuevaFecha: nuevaFecha
                },
                success: function(response) {
                    if (response === 'success') {
                        // Recargar la página después de editar
                        location.reload();
                    } else {
                        alert('Error al editar la nota.');
                    }
                }
            });
        }
    </script>

</body>

</html>