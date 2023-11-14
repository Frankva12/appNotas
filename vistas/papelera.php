<?php
// Llamado a la clase de conexión
include("../conexion/conexion.php");

// Crear una instancia de la clase conexión
$conn = new conexion();

// Establecer consulta de selección a la tabla empleados
$sql = "SELECT n.id, u.usuario, n.titulo, n.descripcion, c.nombre_categoria, n.fecha, n.estado FROM notas n INNER JOIN usuarios u ON n.id_usuario = u.id INNER JOIN categorias c ON u.id = c.id WHERE estado = 0;";

// Ejecutar la consulta SQL
$res = $conn->MostrarSQL($sql);

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
    <title>Notas</title>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="text-center">Notas eliminadas</h1>
            <a href="notas.php" <button class="btn btn-secondary mt-3">Notas</button></a>
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
                            <button class="btn btn-primary mx-2"><i class="fa fa-refresh"></i> Restaurar</button>
                            <button class="btn btn-danger mx-2"><i class="fa fa-trash"></i> Eliminar</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- ... (script section remains the same) ... -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>