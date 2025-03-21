<?php
session_start();
include '../configuracion.php'; // Conexión a la base de datos
include 'cookieSession.php'; // Manejo de cookies

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $correo = trim($_POST['correo']);
    $contraseña = $_POST['contraseña'];

    // Validar datos
    if (empty($correo) || empty($contraseña)) {
        echo "Por favor, ingresa tu correo y contraseña.";
    } else {
        // Buscar el usuario en la base de datos
        $query = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
            // Crear una sesión para el usuario
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            // Si el usuario marca "Recuérdame", se crean cookies válidas por 30 días
            if (!empty($_POST['recordar'])) {
                setcookie("usuario_id", $usuario['id'], time() + (86400 * 30), "/");
                setcookie("nombre", $usuario['nombre'], time() + (86400 * 30), "/");
                setcookie("rol", $usuario['rol'], time() + (86400 * 30), "/");
            }

            // Redirigir al usuario a la página principal
            header("Location: ../index.php");
            exit();
        } else {
            echo "Correo o contraseña incorrectos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>

<body>
    <h1>Iniciar sesión</h1>
    <form method="POST" action="">
        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required>
        <br>
        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>
        <br>
        <label>
            <input type="checkbox" name="recordar"> Recuérdame
        </label>
        <br>
        <button type="submit">Iniciar sesión</button>
    </form>
    <p>¿No tienes cuenta? <a href="registro.php">Regístrate</a></p>
</body>

</html>
