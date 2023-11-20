<?php
include("../conexion/conexion.php");

$conn = new conexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idUsuario = $_POST["id"];
    $nuevoNombre = $_POST["nuevoNombre"];
    $nuevoUsuario = $_POST["nuevoUsuario"];
    $nuevaContrasenia = $_POST["nuevaContrasenia"];
    $nuevoPrivilegio = $_POST["nuevoPrivilegio"];

    try {
        $sqlActualizarUsuario = "UPDATE dbnotas.usuarios SET nombre = :nuevoNombre, usuario = :nuevoUsuario, contrasenia = :nuevaContrasenia, privilegio = :nuevoPrivilegio WHERE id = :idUsuario";

        $stmtActualizar = $conn->pdo()->prepare($sqlActualizarUsuario);
        $stmtActualizar->bindParam(':nuevoNombre', $nuevoNombre, PDO::PARAM_STR);
        $stmtActualizar->bindParam(':nuevoUsuario', $nuevoUsuario, PDO::PARAM_STR);
        $stmtActualizar->bindParam(':nuevaContrasenia', $nuevaContrasenia, PDO::PARAM_STR);
        $stmtActualizar->bindParam(':nuevoPrivilegio', $nuevoPrivilegio, PDO::PARAM_STR);
        $stmtActualizar->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

        $stmtActualizar->execute();

        echo 'success';
        exit();
    } catch (PDOException $ex) {
        echo 'error';
        exit();
    }
} else {
    header("Location: ../vistas/usuarios.php");
    exit();
}
?>
