<?php
include("../conexion/parametros.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"];
    $contrasenia = $_POST["contrasenia"];
    $privilegio = $_POST["privilegio"];
    $nombre = $_POST["nombre"];
    try {
        $connPDO = new PDO('mysql:host=' . server . ';dbname=' . database, user, password);
        $connPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO dbnotas.usuarios (usuario, contrasenia, privilegio, nombre) VALUES (:usuario, :contrasenia, :privilegio, :nombre)";
        $stmt = $connPDO->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->bindParam(':contrasenia', $contrasenia, PDO::PARAM_STR);
        $stmt->bindParam(':privilegio', $privilegio, PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
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
