<?php
session_start();

include("../conexion/conexion.php");

$conn = new conexion();

$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
if ($mensaje === 'success_update') {
    echo '<div id="update-message" class="alert alert-success">El usuario se ha actualizado exitosamente.</div>';
    echo '<script>
            setTimeout(function() {
                $("#update-message").fadeOut("slow");
            }, 3000);
          </script>';
} elseif ($mensaje === 'success_delete') {
    echo '<div id="delete-message" class="alert alert-success">El usuario se ha eliminado exitosamente.</div>';
    echo '<script>
            setTimeout(function() {
                $("#delete-message").fadeOut("slow");
            }, 3000);
          </script>';
}

$sql = "SELECT id, nombre, usuario, contrasenia, privilegio FROM dbnotas.usuarios;";

$res = $conn->MostrarSQL($sql);
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
    <title>Usuarios</title>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="text-center">Lista de Usuarios</h1>
            <a href="agregar_usuarios.php" class="btn btn-primary mt-3">Agregar Usuario</a>
            <a href="notas.php" class="btn btn-secondary mt-3">Notas</a>
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
                                    <button class="btn btn-primary editar-usuario" data-id="<?php echo $fila['id']; ?>" data-nombre="<?php echo $fila['nombre']; ?>" data-usuario="<?php echo $fila['usuario']; ?>" data-contrasenia="<?php echo $fila['contrasenia']; ?>" data-privilegio="<?php echo $fila['privilegio']; ?>" onclick="abrirModalEditarUsuario(this)">
                                        <i class="fa fa-pencil"></i> Editar
                                    </button>

                                    <?php if ($fila['id'] != $_SESSION['usuario_id']) : ?>
                                        <a href="../modelo/eliminar_usuario.php?id=<?php echo $fila['id']; ?>&mensaje=success_delete" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar a este usuario?');">
                                            <i class="fa fa-trash"></i> Eliminar
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para editar usuario -->
    <div class="modal fade" id="editarUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formularioEditarUsuario">
                        <div class="form-group">
                            <label for="nombreUsuario">Nombre:</label>
                            <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" pattern="^[a-zA-Z0-9]{3,80}$" required>
                        </div>
                        <div class="form-group">
                            <label for="usuarioUsuario">Usuario:</label>
                            <input type="text" class="form-control" id="usuarioUsuario" name="usuarioUsuario" placeholder="Usuario" pattern="^[a-zA-Z0-9]{3,80}$" title="Solo se permiten letras y números (sin espacios ni caracteres especiales)" required>
                        </div>
                        <div class="form-group">
                            <label for="usuarioContrasenia">Contraseña:</label>
                            <input type="password" class="form-control" id="usuarioContrasenia" name="usuarioContrasenia" required>
                        </div>
                        <div class="form-group">
                            <label for="privilegioUsuario">Privilegio</label>
                            <select class="form-control mb-3" id="privilegioUsuario" name="privilegioUsuario" required>
                                <option value="administrador">Administrador</option>
                                <option value="cliente">Cliente</option>
                            </select>
                        </div>
                        <input type="hidden" id="idUsuarioEditar" name="idUsuarioEditar">
                        <button type="button" class="btn btn-primary" onclick="editarUsuario()">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../controlador/usuarios.js"></script>
</body>

</html>
