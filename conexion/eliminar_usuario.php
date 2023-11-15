<?php
session_start();

// Verificar si se proporcionó un ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idUsuarioEliminar = $_GET['id'];

    // Obtener el ID del usuario en sesión
    $idUsuarioSesion = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 0;

    // Verificar si el ID del usuario a eliminar es diferente del ID del usuario en sesión
    if ($idUsuarioEliminar != $idUsuarioSesion) {
        // Llamado a la clase de conexión
        include("../conexion/conexion.php");

        // Crear una instancia de la clase conexión
        $conn = new conexion();

        // Preparar la consulta de eliminación
        $sql = "DELETE FROM dbnotas.usuarios WHERE id = :idUsuarioEliminar";

        // Preparar la consulta SQL
        $stmt = $conn->pdo()->prepare($sql);

        // Asociar el parámetro ID del usuario a eliminar a la consulta
        $stmt->bindParam(':idUsuarioEliminar', $idUsuarioEliminar, PDO::PARAM_INT);

        try {
            // Ejecutar la consulta de eliminación
            $stmt->execute();

            // Redirigir a la página de usuarios después de la eliminación
            header("Location: ../vistas/usuarios.php");
            exit();
        } catch (PDOException $e) {
            // Manejar la excepción en caso de un error en la eliminación
            echo "Error al eliminar el usuario: " . $e->getMessage();
        }
    } else {
        // Si el ID del usuario a eliminar es igual al ID del usuario en sesión, mostrar un mensaje de error
        echo "No puedes eliminar tu propio usuario.";
    }
} else {
    // Si no se proporcionó un ID válido, mostrar un mensaje de error
    echo "ID de usuario no válido.";
}
?>
