<?php
session_start();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idUsuarioEliminar = $_GET['id'];

    $idUsuarioSesion = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 0;

    if ($idUsuarioEliminar != $idUsuarioSesion) {
        include("../conexion/conexion.php");

        $conn = new conexion();

        $sql = "DELETE FROM dbnotas.usuarios WHERE id = :idUsuarioEliminar";

        $stmt = $conn->pdo()->prepare($sql);

        $stmt->bindParam(':idUsuarioEliminar', $idUsuarioEliminar, PDO::PARAM_INT);

        try {
            $stmt->execute();

            header("Location: ../vistas/usuarios.php");
            exit();
        } catch (PDOException $e) {
            echo "Error al eliminar el usuario: " . $e->getMessage();
        }
    } else {
        echo "No puedes eliminar tu propio usuario.";
    }
} else {
    echo "ID de usuario no válido.";
}
