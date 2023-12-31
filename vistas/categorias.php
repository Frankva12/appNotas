<?php
include("../conexion/conexion.php");

$conn = new Conexion();

$mensaje_actualizar = "";
$mensaje_eliminar = "";

if (isset($_GET['eliminar'])) {
    $idCategoriaEliminar = $_GET['eliminar'];
    $nombreCategoria = obtenerNombreCategoria($idCategoriaEliminar, $conn);

    echo '<script>
            if(confirm("¿Estás seguro que quieres eliminar la categoría \'' . $nombreCategoria . '\'?")) {
                window.location.href="?confirmar_eliminar=' . $idCategoriaEliminar . '";
            }
          </script>';
}

if (isset($_GET['confirmar_eliminar'])) {
    $idCategoriaEliminar = $_GET['confirmar_eliminar'];

    try {
        $sqlEliminarCategoria = "DELETE FROM categorias WHERE id = :idCategoria";

        $stmtEliminar = $conn->pdo()->prepare($sqlEliminarCategoria);
        $stmtEliminar->bindParam(':idCategoria', $idCategoriaEliminar, PDO::PARAM_INT);

        $stmtEliminar->execute();

        $mensaje_eliminar = "Categoría eliminada correctamente.";

        header("Location: categorias.php");
        exit();
    } catch (PDOException $ex) {
        // Manejar la excepción de restricción de clave externa
        if ($ex->getCode() == '23000') {
            $mensaje_eliminar = "No se puede eliminar la categoría porque pertenece a una nota.";
        } else {
            // Otra excepción, mostrar el mensaje de error
            $mensaje_eliminar = "Error: " . $ex->getMessage();
        }
    }
}

function obtenerNombreCategoria($idCategoria, $conn)
{
    $sql = "SELECT nombre_categoria FROM categorias WHERE id = :idCategoria";
    $stmt = $conn->pdo()->prepare($sql);
    $stmt->bindParam(':idCategoria', $idCategoria, PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    return $resultado['nombre_categoria'];
}

$sql = "SELECT id, nombre_categoria FROM categorias;";

$res = $conn->MostrarSQL($sql);
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
    <title>Categorías</title>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="text-center">Mis Categorías</h1>
            <a href="agregar_categorias.php" class="btn btn-primary mt-3">Agregar Categorías</a>
            <a href="notas.php" class="btn btn-secondary mt-3">Notas</a>
        </div>
        <!-- Mensaje de actualización -->
        <?php if ($mensaje_actualizar) : ?>
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <?php echo $mensaje_actualizar; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Mensaje de eliminación -->
        <?php if ($mensaje_eliminar) : ?>
            <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                <?php echo $mensaje_eliminar; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="row mt-4">
            <?php if (empty($res)) : ?>
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        No hay categorías disponibles.
                    </div>
                </div>
            <?php else : ?>
                <?php foreach ($res as $categoria) : ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card bg-white">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $categoria['nombre_categoria']; ?></h5>
                                <!-- Update and Delete buttons -->
                                <div class="text-center mt-3">
                                    <a href="?eliminar=<?php echo $categoria['id']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</a>
                                    <button class="btn btn-warning" onclick="abrirModalEditar(<?php echo $categoria['id']; ?>, '<?php echo $categoria['nombre_categoria']; ?>')"><i class="fa fa-pencil"></i> Editar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal para editar categoría -->
    <div class="modal fade" id="editarCategoriaModal" tabindex="-1" role="dialog" aria-labelledby="editarCategoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarCategoriaModalLabel">Editar Categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formularioEditarCategoria" method="post" action="">
                        <div class="form-group">
                            <label for="nombreCategoria">Nombre de la categoría:</label>
                            <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria" required maxlength="80">
                        </div>
                        <input type="hidden" id="idCategoriaEditar" name="idCategoriaEditar">
                        <button type="submit" class="btn btn-primary" onclick="editarCategoria()">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../controlador/categorias.js"></script>
</body>

</html>
