<?php
// Llamado a la clase de conexión
include("../conexion/conexion.php");

// Crear una instancia de la clase conexión
$conn = new conexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $nuevoTitulo = $_POST['nuevoTitulo'];
    $nuevaDescripcion = $_POST['nuevaDescripcion'];
    $nuevaCategoria = $_POST['nuevaCategoria'];
    $nuevaFecha = $_POST['nuevaFecha'];

    try {
        // Preparar la consulta SQL para actualizar la nota
        $sqlActualizarNota = "UPDATE notas SET titulo = :nuevoTitulo, descripcion = :nuevaDescripcion, categoria_id = :nuevaCategoria, fecha = :nuevaFecha WHERE id = :id";

        // Preparar la consulta
        $stmtActualizar = $conn->pdo()->prepare($sqlActualizarNota);
        $stmtActualizar->bindParam(':nuevoTitulo', $nuevoTitulo, PDO::PARAM_STR);
        $stmtActualizar->bindParam(':nuevaDescripcion', $nuevaDescripcion, PDO::PARAM_STR);
        $stmtActualizar->bindParam(':nuevaCategoria', $nuevaCategoria, PDO::PARAM_INT);
        $stmtActualizar->bindParam(':nuevaFecha', $nuevaFecha, PDO::PARAM_STR);
        $stmtActualizar->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmtActualizar->execute();

        // Responder con éxito
        echo 'success';
    } catch (PDOException $ex) {
        // Manejar la excepción
        echo 'error';
    }
}
?>
