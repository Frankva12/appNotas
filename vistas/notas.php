<?php
session_start(); // Iniciar sesión

// Llamado a la clase de conexión
include("../conexion/conexion.php");

// Crear una instancia de la clase conexión
$conn = new conexion();

// Obtener el ID del usuario en sesión
$idUsuario = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 0;

// Establecer consulta de selección a la tabla empleados
$sql = "SELECT n.id, u.usuario, n.titulo, n.descripcion, c.nombre_categoria, n.fecha, n.estado 
        FROM notas n 
        INNER JOIN usuarios u ON n.id_usuario = u.id 
        INNER JOIN categorias c ON u.id = c.id 
        WHERE estado = 1 AND n.id_usuario = :idUsuario;";

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                            <button class="btn btn-info mx-2"><i class="fa fa-pencil"></i> Editar</button>
                            <button class="btn btn-danger mx-2 eliminar-nota" data-id="<?php echo $row['id']; ?>">
                                <i class="fa fa-trash"></i> Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <script>
        $(document).ready(function() {
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
    </script>
</body>

</html>
