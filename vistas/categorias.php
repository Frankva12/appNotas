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
function obtenerNombreCategoria($idCategoria, $conn) {
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
                                <button class="btn btn-warning"><i class="fa fa-pencil"></i> Editar</button>
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
