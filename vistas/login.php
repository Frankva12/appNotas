<?php
session_start(); // Iniciar sesión

// Verificar si el usuario ya está autenticado
if (isset($_SESSION['usuario_id'])) {
    header("Location: notas.php"); // Redirigir a la página de inicio si ya está autenticado
    exit();
}

// Verificar si se envió el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tu código de conexión a la base de datos
    include("../conexion/conexion.php");
    $miConexion = new Conexion();

    // Recuperar credenciales del formulario
    $usuario = $_POST['username'];
    $contrasenia = $_POST['password'];

    // Consulta SQL para verificar las credenciales
    $query = "SELECT id, usuario, privilegio FROM usuarios WHERE usuario = :usuario AND contrasenia = :contrasenia";
    $stmt = $miConexion->pdo()->prepare($query);
    $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $stmt->bindParam(':contrasenia', $contrasenia, PDO::PARAM_STR);
    $stmt->execute();

    // Verificar si se encontró un usuario con las credenciales proporcionadas
    if ($stmt->rowCount() == 1) {
        $usuario_info = $stmt->fetch(PDO::FETCH_ASSOC);

        // Almacenar el ID del usuario en la sesión
        $_SESSION['usuario_id'] = $usuario_info['id'];
        $_SESSION['usuario_nombre'] = $usuario_info['usuario'];
        $_SESSION['usuario_privilegio'] = $usuario_info['privilegio'];

        // Redirigir a la página de inicio con un mensaje de éxito
        header("Location: notas.php?mensaje=success_login");
        exit();
    } else {
        $mensaje_error = "Credenciales incorrectas. Por favor, intenta de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Inicio de Sesión</title>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center">Inicio de Sesión</h3>
                        <form method="post">
                            <div class="form-group">
                                <label for="username">Usuario</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Usuario" required maxlength="40">
                                <div class="invalid-feedback">Usuario inválido. Debe tener entre 1 y 40 caracteres.</div>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required minlength="3" maxlength="40">
                                <div class="invalid-feedback">Contraseña inválida. Debe tener entre 3 y 40 caracteres.</div>
                            </div>
                            <?php
                            if (isset($mensaje_error)) {
                                echo "<div class='alert alert-danger'>$mensaje_error</div>";
                            }
                            ?>
                            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
