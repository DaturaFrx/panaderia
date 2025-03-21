<?php
session_start();

// Destruir la sesión
session_destroy();

// Eliminar las cookies de sesión si existen
setcookie("usuario_id", "", time() - 3600, "/");
setcookie("nombre", "", time() - 3600, "/");
setcookie("rol", "", time() - 3600, "/");

// Redirigir al usuario al inicio
header("Location: ../index.php");
exit();
?>
