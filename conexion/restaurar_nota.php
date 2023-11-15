<?php
// Llamado a la clase de conexión
include("conexion.php");

// Obtener el ID de la nota a restaurar
$idNota = isset($_POST['id']) ? $_POST['id'] : 0;

// Crear una instancia de la clase conexión
$conn = new conexion();

// Establecer consulta para cambiar el estado de la nota a activo (estado = 1)
$sql = "UPDATE notas SET estado = 1 WHERE id = :idNota";

// Preparar la consulta SQL
$stmt = $conn->pdo()->prepare($sql);

// Asociar el parámetro ID de la nota a restaurar a la consulta
$stmt->bindParam(':idNota', $idNota, PDO::PARAM_INT);

// Ejecutar la consulta SQL
$stmt->execute();

// Devolver una respuesta en formato JSON
echo json_encode(["status" => "success"]);
?>
