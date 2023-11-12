<?php
include("parametros.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $descuento = $_POST["descuento"];
    try {
        $connPDO = new PDO('mysql:host='.server.';dbname='.database, user, password);
        $connPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO bdlaboratorio2.tblproductos (NOMBRE, PRECIO, DESCUENTO) VALUES (:nombre, :precio, :descuento)";
        $stmt = $connPDO->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':precio', $precio, PDO::PARAM_INT);
        $stmt->bindParam(':descuento', $descuento, PDO::PARAM_INT);
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
