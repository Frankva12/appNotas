<?php
// Llamado a la clase de conexión
include("../conexion/conexion.php");

// Crear una instancia de la clase conexión
$conn = new conexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $idCategoria = $_POST["id"];
    $nuevoNombre = $_POST["nuevoNombre"];

    try {
        // Preparar la consulta SQL para actualizar el nombre de la categoría
        $sqlActualizarCategoria = "UPDATE categorias SET nombre_categoria = :nuevoNombre WHERE id = :idCategoria";

        // Preparar la consulta
        $stmtActualizar = $conn->pdo()->prepare($sqlActualizarCategoria);
        $stmtActualizar->bindParam(':nuevoNombre', $nuevoNombre, PDO::PARAM_STR);
        $stmtActualizar->bindParam(':idCategoria', $idCategoria, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmtActualizar->execute();

        // Enviar una respuesta de éxito al cliente
        echo 'success';
        exit();
    } catch (PDOException $ex) {
        // Manejar cualquier error durante la actualización
        echo 'error';
        exit();
    }
} else {
    // Si no es una solicitud POST, redirigir a la página principal o manejar de acuerdo a tus necesidades
    header("Location: categorias.php");
    exit();
}
?>
