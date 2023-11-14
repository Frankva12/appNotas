<?php
include("../conexion/conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idNota = $_POST["id"];
    $estado = $_POST["estado"];

    try {
        $connPDO = new PDO('mysql:host='.server.';dbname='.database, user, password);
        $connPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE notas SET estado = :estado WHERE id = :id";
        $stmt = $connPDO->prepare($sql);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
        $stmt->bindParam(':id', $idNota, PDO::PARAM_INT);
        $stmt->execute();

        $response = array("status" => "success", "message" => "Estado de la nota cambiado exitosamente");
        echo json_encode($response);
    } catch (PDOException $e) {
        $response = array("status" => "error", "message" => "Error de la base de datos: " . $e->getMessage());
        echo json_encode($response);
    }
} else {
    $response = array("status" => "error", "message" => "Método de solicitud no válido");
    echo json_encode($response);
}
?>
