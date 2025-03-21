<?php
session_start();  // Inicia la sesión para verificar el estado del usuario
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
</head>

<body>
    <header class="header-principal">
        <h1>Bienvenido a la Panadería</h1>

        <!-- Menú de navegación -->
        <nav>
            <ul>
                <?php
                // Verificar si el usuario está logueado
                if (isset($_SESSION['usuario_id'])) {
                    // Si el usuario está logueado, mostrar su nombre y la opción de cerrar sesión
                    echo "<li>Hola, " . $_SESSION['nombre'] . "</li>";
                    echo "<li><a class='header-a' href='usuario/logout.php'>Cerrar sesión</a></li>";
                } else {
                    // Si el usuario no está logueado, mostrar las opciones de login y registro
                    echo "<li><a class='header-a' href='usuario/login.php'>Iniciar sesión</a></li>";
                    echo "<li><a class='header-a' href='usuario/registro.php'>Registrar</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>
</body>

</html>
