<?php
session_start(); // Iniciar sesión

// Llamado a la clase de conexión
include("../conexion/conexion.php");

// Crear una instancia de la clase conexión
$conn = new conexion();

// Obtener el ID del usuario en sesión
$idUsuario = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 0;

// Verificar si hay un mensaje en el URL y mostrarlo
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
if ($mensaje === 'success_restore') {
    echo '<div id="restore-message" class="alert alert-success">La nota se ha restaurado exitosamente.</div>';
    echo '<script>
            setTimeout(function() {
                $("#restore-message").fadeOut("slow");
            }, 3000);
          </script>';
} elseif ($mensaje === 'success_permanent_delete') {
    echo '<div id="permanent-delete-message" class="alert alert-danger">La nota se ha eliminado permanentemente.</div>';
    echo '<script>
            setTimeout(function() {
                $("#permanent-delete-message").fadeOut("slow");
            }, 3000);
          </script>';
}

// Establecer consulta de selección a la tabla notas eliminadas del usuario
$sql = "SELECT n.id, u.usuario, n.titulo, n.descripcion, c.nombre_categoria, n.fecha, n.estado 
        FROM notas n 
        INNER JOIN usuarios u ON n.id_usuario = u.id 
        INNER JOIN categorias c ON n.categoria_id = c.id 
        WHERE n.estado = 0 AND n.id_usuario = :idUsuario
        ORDER BY n.fecha ASC";

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../controlador/papelera.js"></script>
    <title>Notas</title>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="text-center">Notas eliminadas</h1>
            <a href="notas.php" class="btn btn-secondary mt-3">Notas</a>
        </div>
        <div class="row mt-4">
            <?php if (empty($res)) : ?>
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        No hay notas en la papelera.
                    </div>
                </div>
            <?php else : ?>
                <?php foreach ($res as $row) { ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card <?php echo getCardClass($row['fecha']); ?>">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo $row['titulo']; ?></h5>
                                <p class="card-text"><?php echo $row['descripcion']; ?></p>
                                <p class="card-text"><strong>Categoría:</strong> <?php echo $row['nombre_categoria']; ?></p>
                                <p class="card-text"><strong>Fecha:</strong> <?php echo $row['fecha']; ?></p>
                                <button class="btn btn-primary mx-2" onclick="restaurarNota(<?php echo $row['id']; ?>)"><i class="fa fa-refresh"></i> Restaurar</button>
                                <button class="btn btn-danger mx-2" onclick="eliminarNota(<?php echo $row['id']; ?>)"><i class="fa fa-trash"></i> Eliminar</button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>