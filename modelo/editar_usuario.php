<?php
// Llamado a la clase de conexión
include("../conexion/conexion.php");

// Crear una instancia de la clase conexión
$conn = new conexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $idUsuario = $_POST["id"];
    $nuevoNombre = $_POST["nuevoNombre"];
    $nuevoUsuario = $_POST["nuevoUsuario"];
    $nuevaContrasenia = $_POST["nuevaContrasenia"];
    $nuevoPrivilegio = $_POST["nuevoPrivilegio"];

    try {
        // Preparar la consulta SQL para actualizar el usuario
        $sqlActualizarUsuario = "UPDATE dbnotas.usuarios SET nombre = :nuevoNombre, usuario = :nuevoUsuario, contrasenia = :nuevaContrasenia, privilegio = :nuevoPrivilegio WHERE id = :idUsuario";

        // Preparar la consulta
        $stmtActualizar = $conn->pdo()->prepare($sqlActualizarUsuario);
        $stmtActualizar->bindParam(':nuevoNombre', $nuevoNombre, PDO::PARAM_STR);
        $stmtActualizar->bindParam(':nuevoUsuario', $nuevoUsuario, PDO::PARAM_STR);
        $stmtActualizar->bindParam(':nuevaContrasenia', $nuevaContrasenia, PDO::PARAM_STR);
        $stmtActualizar->bindParam(':nuevoPrivilegio', $nuevoPrivilegio, PDO::PARAM_STR);
        $stmtActualizar->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

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
    header("Location: ../vistas/usuarios.php");
    exit();
}
?>
