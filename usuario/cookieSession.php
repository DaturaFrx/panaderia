<?php
// Verificar si ya hay una sesión activa antes de iniciar una nueva sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si las cookies de sesión existen y la sesión no está iniciada aún
if (!isset($_SESSION['usuario_id']) && isset($_COOKIE['usuario_id'])) {
    $_SESSION['usuario_id'] = $_COOKIE['usuario_id'];
    $_SESSION['nombre'] = $_COOKIE['nombre'];
    $_SESSION['rol'] = $_COOKIE['rol'];
}
?>
