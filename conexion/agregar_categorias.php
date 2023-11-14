<?php
include("parametros.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    try {
        $connPDO = new PDO('mysql:host='.server.';dbname='.database, user, password);
        $connPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO dbnotas.categorias (nombre_categoria) VALUES (:nombre_categoria)";
        $stmt = $connPDO->prepare($sql);
        $stmt->bindParam(':nombre_categoria', $nombre, PDO::PARAM_STR);
        $stmt->execute();
        $response = array("status" => "success", "message" => "Data inserted successfully");
        echo json_encode($response);
    } catch (PDOException $e) {
        $response = array("status" => "error", "message" => "Database error: " . $e->getMessage());
        echo json_encode($response);
    }
} else {
    $response = array("status" => "error", "message" => "Invalid request method");
    echo json_encode($response);
}
