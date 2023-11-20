<?php
session_start();

include("../conexion/conexion.php");

$conn = new conexion();

$idUsuario = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 0;

// Verificar si hay un mensaje en el URL y mostrarlo
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
if ($mensaje === 'success_update') {
    echo '<div id="success-message" class="alert alert-success">La nota se ha actualizado exitosamente.</div>';
    echo '<script>
            setTimeout(function() {
                $("#success-message").fadeOut("slow");
            }, 3000);
          </script>';
} elseif ($mensaje === 'success_delete') {
    echo '<div id="delete-message" class="alert alert-danger">La nota se ha eliminado correctamente.</div>';
    echo '<script>
            setTimeout(function() {
                $("#delete-message").fadeOut("slow");
            }, 3000);
          </script>';
}

// Establecer consulta de selección a la tabla notas
$sql = "SELECT n.id, u.usuario, n.titulo, n.descripcion, c.nombre_categoria, n.fecha, n.estado 
        FROM notas n 
        INNER JOIN usuarios u ON n.id_usuario = u.id 
        INNER JOIN categorias c ON n.categoria_id = c.id 
        WHERE n.estado = 1 AND n.id_usuario = :idUsuario
        ORDER BY n.fecha ASC;
        ";

$stmt = $conn->pdo()->prepare($sql);

// Asociar el parámetro ID del usuario en sesión a la consulta
$stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

$stmt->execute();

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
            <a href="../modelo/cerrar_session.php" class="btn btn-danger mt-3">Cerrar Sesión</a>
        </div>

        <?php if (empty($res)) : ?>
            <div class="alert alert-info mt-3" role="alert">
                No hay notas para este usuario.
            </div>
        <?php else : ?>
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
        <?php endif; ?>
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
                            <input type="text" class="form-control" id="tituloNota" name="tituloNota" required maxlength="100">
                        </div>
                        <div class="form-group">
                            <label for="descripcionNota">Descripción:</label>
                            <textarea class="form-control" id="descripcionNota" name="descripcionNota" rows="3"></textarea>
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

    <script src="../controlador/notas.js"></script>
</body>

</html>
