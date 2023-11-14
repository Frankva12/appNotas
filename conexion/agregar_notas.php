<?php
include("../conexion/parametros.php");
session_start(); // Iniciar la sesión si no está iniciada

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Asegurarse de que la variable de sesión usuario_id esté definida
    if (!isset($_SESSION['usuario_id'])) {
        $response = array("status" => "error", "message" => "User not authenticated");
        echo json_encode($response);
        exit();
    }

    $id_usuario = $_SESSION['usuario_id']; // Obtener el ID de usuario de la sesión
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $categoria = $_POST["categoria"];
    $fecha = $_POST["fecha"];

    try {
        $connPDO = new PDO('mysql:host='.server.';dbname='.database, user, password);
        $connPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "INSERT INTO notas (id_usuario, titulo, descripcion, categoria_id, fecha) VALUES (:id_usuario, :titulo, :descripcion, :categoria, :fecha)";
        $stmt = $connPDO->prepare($sql);
        
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);

        $stmt->execute();

        $response = array("status" => "success", "message" => "Note added successfully");
        echo json_encode($response);
    } catch (PDOException $e) {
        $response = array("status" => "error", "message" => "Database error: " . $e->getMessage());
        echo json_encode($response);
    }
} else {
    $response = array("status" => "error", "message" => "Invalid request method");
    echo json_encode($response);
}
?>
