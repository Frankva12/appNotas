<?php
include("../conexion/conexion.php");

$conn = new conexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $nuevoTitulo = $_POST['nuevoTitulo'];
    $nuevaDescripcion = $_POST['nuevaDescripcion'];
    $nuevaCategoria = $_POST['nuevaCategoria'];
    $nuevaFecha = $_POST['nuevaFecha'];

    try {
        $sqlActualizarNota = "UPDATE notas SET titulo = :nuevoTitulo, descripcion = :nuevaDescripcion, categoria_id = :nuevaCategoria, fecha = :nuevaFecha WHERE id = :id";

        $stmtActualizar = $conn->pdo()->prepare($sqlActualizarNota);
        $stmtActualizar->bindParam(':nuevoTitulo', $nuevoTitulo, PDO::PARAM_STR);
        $stmtActualizar->bindParam(':nuevaDescripcion', $nuevaDescripcion, PDO::PARAM_STR);
        $stmtActualizar->bindParam(':nuevaCategoria', $nuevaCategoria, PDO::PARAM_INT);
        $stmtActualizar->bindParam(':nuevaFecha', $nuevaFecha, PDO::PARAM_STR);
        $stmtActualizar->bindParam(':id', $id, PDO::PARAM_INT);

        $stmtActualizar->execute();
        echo 'success';
    } catch (PDOException $ex) {
        echo 'error';
    }
}
