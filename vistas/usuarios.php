<?php
session_start();

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
                                        <a href="../conexion/eliminar_usuario.php?id=<?php echo $fila['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar a este usuario?');">
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
                            <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" required>
                        </div>
                        <div class="form-group">
                            <label for="usuarioUsuario">Usuario:</label>
                            <input type="text" class="form-control" id="usuarioUsuario" name="usuarioUsuario" required>
                        </div>
                        <div class="form-group">
                            <label for="contrasenia">Contraseña:</label>
                            <input type="password" class="form-control" id="usuarioContrasenia" name="contrasenia" required>
                        </div>
                        <div class="form-group">
                            <label for="privilegioUsuario">Privilegio</label>
                            <select class="form-control mb-3" id="privilegioUsuario" name="privilegioUsuario">
                                <option value="administrador">Administrador</option>
                                <option value="cliente">Cliente</option>
                            </select>
                            <input type="hidden" id="idUsuarioEditar" name="idUsuarioEditar">
                            <button type="button" class="btn btn-primary" onclick="editarUsuario()">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function abrirModalEditarUsuario(element) {
            var id = $(element).data('id');
            var nombre = $(element).data('nombre');
            var usuario = $(element).data('usuario');
            var contrasenia = $(element).data('contrasenia');
            var privilegio = $(element).data('privilegio');

            $('#idUsuarioEditar').val(id);
            $('#nombreUsuario').val(nombre);
            $('#usuarioUsuario').val(usuario);
            $('#usuarioContrasenia').val(contrasenia);
            $('#privilegioUsuario').val(privilegio);

            $('#editarUsuarioModal').modal('show');
        }

        // Función para enviar la solicitud de edición de usuario
        function editarUsuario() {
            var id = $('#idUsuarioEditar').val();
            var nuevoNombre = $('#nombreUsuario').val();
            var nuevoUsuario = $('#usuarioUsuario').val();
            var nuevaContrasenia = $('#usuarioContrasenia').val();
            var nuevoPrivilegio = $('#privilegioUsuario').val();

            // Realizar la solicitud AJAX para editar el usuario
            $.ajax({
                url: '../conexion/editar_usuario.php', // Reemplaza con el nombre de tu archivo de edición de usuario
                type: 'POST',
                data: {
                    id: id,
                    nuevoNombre: nuevoNombre,
                    nuevoUsuario: nuevoUsuario,
                    nuevaContrasenia: nuevaContrasenia,
                    nuevoPrivilegio: nuevoPrivilegio
                },
                success: function(response) {
                    if (response === 'success') {
                        // Recargar la página después de editar
                        location.reload();
                    } else {
                        alert('Error al editar el usuario.');
                    }
                }
            });
        }
    </script>
</body>

</html>