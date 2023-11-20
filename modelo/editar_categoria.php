<?php
include("../conexion/conexion.php");

$conn = new conexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCategoria = $_POST["id"];
    $nuevoNombre = $_POST["nuevoNombre"];

    try {
        $sqlActualizarCategoria = "UPDATE categorias SET nombre_categoria = :nuevoNombre WHERE id = :idCategoria";

        $stmtActualizar = $conn->pdo()->prepare($sqlActualizarCategoria);
        $stmtActualizar->bindParam(':nuevoNombre', $nuevoNombre, PDO::PARAM_STR);
        $stmtActualizar->bindParam(':idCategoria', $idCategoria, PDO::PARAM_INT);

        $stmtActualizar->execute();

        echo 'success';
        exit();
    } catch (PDOException $ex) {
        echo 'error';
        exit();
    }
} else {
    header("Location: categorias.php");
    exit();
}
