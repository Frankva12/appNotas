<?php
session_start(); // Iniciar sesión
// Destruir todas las variables de sesión
session_destroy();
// Redireccionar a la página de inicio de sesión u otra página después de cerrar sesión
header("Location: ../vistas/login.php");
exit();
?>
