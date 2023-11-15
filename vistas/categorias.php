<?php
// Llamado a la clase de conexión
include("../conexion/conexion.php");

// Crear una instancia de la clase conexión
$conn = new conexion();

// Verificar si se ha enviado un ID de categoría para eliminar
if (isset($_GET['eliminar'])) {
    $idCategoriaEliminar = $_GET['eliminar'];

    // Obtener el nombre de la categoría para mostrar en el mensaje de confirmación
    $nombreCategoria = obtenerNombreCategoria($idCategoriaEliminar, $conn);

    // Mostrar el mensaje de confirmación
    echo '<script>
            if(confirm("¿Estás seguro que quieres eliminar la categoría \'' . $nombreCategoria . '\'?")) {
                window.location.href="?confirmar_eliminar=' . $idCategoriaEliminar . '";
            }
          </script>';
}

// Verificar si se ha confirmado la eliminación
if (isset($_GET['confirmar_eliminar'])) {
    $idCategoriaEliminar = $_GET['confirmar_eliminar'];

    try {
        // Preparar la consulta SQL para eliminar la categoría
        $sqlEliminarCategoria = "DELETE FROM categorias WHERE id = :idCategoria";

        // Preparar la consulta
        $stmtEliminar = $conn->pdo()->prepare($sqlEliminarCategoria);
        $stmtEliminar->bindParam(':idCategoria', $idCategoriaEliminar, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmtEliminar->execute();

        // Redireccionar a la página de categorías después de eliminar
        header("Location: categorias.php");
        exit();
    } catch (PDOException $ex) {
        // Manejar la excepción de restricción de clave externa
        if ($ex->getCode() == '23000') {
            echo '<script>alert("No se puede eliminar la categoría porque pertenece a una nota.");</script>';
        } else {
            // Otra excepción, mostrar el mensaje de error
            echo "Error: " . $ex->getMessage();
        }
    }
}

// Función para obtener el nombre de la categoría
function obtenerNombreCategoria($idCategoria, $conn)
{
    $sql = "SELECT nombre_categoria FROM categorias WHERE id = :idCategoria";
    $stmt = $conn->pdo()->prepare($sql);
    $stmt->bindParam(':idCategoria', $idCategoria, PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    return $resultado['nombre_categoria'];
}

// Establecer consulta de selección a la tabla categorías
$sql = "SELECT id, nombre_categoria FROM categorias;";

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
        <div class="row mt-4">
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
                    <form id="formularioEditarCategoria">
                        <div class="form-group">
                            <label for="nombreCategoria">Nombre de la categoría:</label>
                            <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria" required>
                        </div>
                        <input type="hidden" id="idCategoriaEditar" name="idCategoriaEditar">
                        <button type="button" class="btn btn-primary" onclick="editarCategoria()">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Función para abrir el modal de edición
        function abrirModalEditar(id, nombre) {
            $('#idCategoriaEditar').val(id);
            $('#nombreCategoria').val(nombre);
            $('#editarCategoriaModal').modal('show');
        }

        // Función para enviar la solicitud de edición
        function editarCategoria() {
            var id = $('#idCategoriaEditar').val();
            var nuevoNombre = $('#nombreCategoria').val();

            // Realizar la solicitud AJAX para editar la categoría
            $.ajax({
                url: '../conexion/editar_categoria.php', // Reemplaza con el nombre de tu archivo de edición
                type: 'POST',
                data: {
                    id: id,
                    nuevoNombre: nuevoNombre
                },
                success: function(response) {
                    if (response === 'success') {
                        location.reload();
                    } else {
                        alert('Error al editar la categoría.');
                    }
                }
            });
        }
    </script>
</body>

</html>