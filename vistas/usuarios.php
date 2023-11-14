<?php
// Llamado a la clase de conexión
include("../conexion/conexion.php");

// Crear una instancia de la clase conexión
$conn = new conexion();

// Establecer consulta de selección a la tabla empleados
$sql = "SELECT id, nombre, usuario, contrasenia, privilegio FROM dbnotas.usuarios;";

// Ejecutar la consulta SQL
$res = $conn->MostrarSQL($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Usuarios</title>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="text-center">Lista de Usuarios</h1>
            <a href="agregar_usuarios.php" class="btn btn-primary mt-3">Agregar Usuario</a>
            <a href="notas.php" <button class="btn btn-secondary mt-3">Notas</button></a>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Privilegio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($res as $fila) : ?>
                        <tr>
                            <td><?php echo $fila['id']; ?></td>
                            <td><?php echo $fila['nombre']; ?></td>
                            <td><?php echo $fila['usuario']; ?></td>
                            <td><?php echo $fila['privilegio']; ?></td>
                            <td>
                                <div class="text-center">
                                    <button class="btn btn-primary"><i class="fa fa-pencil"></i> Editar</button>
                                    <button class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>