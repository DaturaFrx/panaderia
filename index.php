<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panadería - Menú Principal</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <style>
        /* Estilos para el iframe */
        .productos-iframe {
            width: 100%;
            height: 800px; /* Ajusta la altura según necesites */
            border: none;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    <header class="header-index">
        <h1>Panal</h1>
        <nav>
            <ul>
                <li><a href="hacer_pedido.php">Hacer pedido</a></li>
                <li><a href="ver_pedidos.php">Ver pedidos</a></li>
                <li><a href="salir.php">Salir</a></li>
            </ul>
        </nav>
    </header>
   
    <!-- Usamos un iframe para aislar completamente los estilos -->
    <iframe src="productos/productos.php" class="productos-iframe" title="Productos"></iframe>
   
    <?php include('footer.php'); ?>
</body>
</html>