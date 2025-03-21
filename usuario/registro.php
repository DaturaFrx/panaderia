<?php
include '../configuracion.php'; // Conexión a la base de datos
// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $rol = 'cliente';  // Por defecto, todos los usuarios registrados son clientes

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($correo) || empty($contraseña)) {
        $mensaje_error = "Por favor, rellena todos los campos.";
    } else {
        // Verificar si el correo ya existe en la base de datos
        $query = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$correo]);
        if ($stmt->rowCount() > 0) {
            $mensaje_error = "El correo electrónico ya está registrado.";
        } else {
            // Hash de la contraseña para almacenarla de manera segura
            $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);
            // Insertar el nuevo usuario en la base de datos
            $query = "INSERT INTO usuarios (nombre, correo, contraseña, rol)
                      VALUES (?, ?, ?, ?)";
            $stmt = $conexion->prepare($query);
            if ($stmt->execute([$nombre, $correo, $contraseña_hash, $rol])) {
                $mensaje_exito = "¡Registro exitoso! Ahora puedes iniciar sesión.";
            } else {
                $mensaje_error = "Hubo un error en el registro. Intenta nuevamente.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <div class="container">
        <h1>Registro de Usuario</h1>

        <?php if (isset($mensaje_error)): ?>
            <div class="mensaje error"><?php echo $mensaje_error; ?></div>
        <?php endif; ?>

        <?php if (isset($mensaje_exito)): ?>
            <div class="mensaje exito"><?php echo $mensaje_exito; ?></div>
        <?php endif; ?>

        <form method="POST" action="" class="formulario">
            <div class="campo">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="campo">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" required>
            </div>

            <div class="campo">
                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" required>
            </div>

            <button type="submit" class="boton">Registrar</button>
        </form>

        <p class="enlace">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </div>
</body>

</html>