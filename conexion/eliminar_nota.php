<?php
// Llamado a la clase de conexión
include("conexion.php");

// Obtener el ID de la nota a eliminar permanentemente
$idNota = isset($_POST['id']) ? $_POST['id'] : 0;

// Crear una instancia de la clase conexión
$conn = new conexion();

// Establecer consulta para eliminar permanentemente la nota
$sql = "DELETE FROM notas WHERE id = :idNota";

// Preparar la consulta SQL
$stmt = $conn->pdo()->prepare($sql);

// Asociar el parámetro ID de la nota a eliminar permanentemente a la consulta
$stmt->bindParam(':idNota', $idNota, PDO::PARAM_INT);

// Ejecutar la consulta SQL
$stmt->execute();

// Devolver una respuesta en formato JSON
echo json_encode(["status" => "success"]);
?>