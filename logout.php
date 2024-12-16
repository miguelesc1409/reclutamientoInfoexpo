<?php
session_start(); // Iniciar la sesión

// Eliminar todas las variables de sesión
$_SESSION = array();

// Si se desea, destruir la sesión
session_destroy();

// Redirigir al usuario a la página de login
header("Location: login.php");
exit;
?>