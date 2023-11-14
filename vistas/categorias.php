<?php
// Llamado a la clase de conexión
include("../conexion/conexion.php");

// Crear una instancia de la clase conexión
$conn = new conexion();

// Establecer consulta de selección a la tabla empleados
$sql = "SELECT nombre_categoria FROM dbnotas.categorias;";

// Ejecutar la consulta SQL
$res = $conn->MostrarSQL($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Categorías</title>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="text-center">Mis Categorías</h1>
            <a href="agregar_categorias.php" <button class="btn btn-primary mt-3">Agregar Categorias</button></a>
            <a href="notas.php" <button class="btn btn-secondary mt-3">Notas</button></a>
        </div>
        <div class="row mt-4">
            <?php foreach ($res as $categoria) : ?>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card bg-white">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $categoria['nombre_categoria']; ?></h5>
                            <!-- Update and Delete buttons -->
                            <div class="text-center mt-3">
                                <button class="btn btn-warning"><i class="fa fa-pencil"></i> Editar</button>
                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>