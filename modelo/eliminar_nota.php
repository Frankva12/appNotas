<?php
include("../conexion/conexion.php");

$idNota = isset($_POST['id']) ? $_POST['id'] : 0;

$conn = new conexion();

$sql = "DELETE FROM notas WHERE id = :idNota";

$stmt = $conn->pdo()->prepare($sql);

$stmt->bindParam(':idNota', $idNota, PDO::PARAM_INT);

$stmt->execute();

echo json_encode(["status" => "success"]);
