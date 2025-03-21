<?php
include '../configuracion.php';
// Obtener categorías
$query_categorias = "SELECT * FROM categorias";
$result_categorias = $conexion->query($query_categorias);
// Obtener productos organizados por categoría
$query_productos = "SELECT p.nombre, p.descripcion, p.precio, p.stock, p.imagen, c.nombre AS categoria
                    FROM productos p
                    INNER JOIN categorias c ON p.categoria_id = c.id
                    ORDER BY c.nombre, p.nombre";
$result_productos = $conexion->query($query_productos);
// Organizar productos por categoría
$productos_por_categoria = [];
while ($producto = $result_productos->fetch(PDO::FETCH_ASSOC)) {
    $productos_por_categoria[$producto['categoria']][] = $producto;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <!-- Solo incluimos las variables y el estilo de productos -->
    <link rel="stylesheet" href="css/variables.css">
    <style>
        /* Estilos específicos para la página de productos */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 15px;
        }

        h1 {
            color: #ff7f50;
            text-align: center;
            margin-bottom: 25px;
            font-size: 28px;
        }

        /* Estilos para las pestañas */
        .tabs {
            width: 100%;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .tab-list {
            display: flex;
            list-style: none;
            background-color: #f5f5f5;
            border-bottom: 1px solid #e0e0e0;
            padding: 0;
            margin: 0;
        }

        .tab-link {
            padding: 12px 20px;
            cursor: pointer;
            font-weight: bold;
            color: #333333;
            transition: background-color 0.3s;
        }

        .tab-link:hover {
            background-color: #e8e8e8;
        }

        .tab-link.active {
            background-color: #ffffff;
            border-bottom: 3px solid #ff7f50;
            color: #ff7f50;
        }

        /* Contenido de pestañas */
        .tab-content {
            display: none;
            padding: 20px;
        }

        /* Estilos para los productos */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .product-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .product-card h3 {
            font-size: 18px;
            margin: 10px 0;
            color: #333333;
        }

        .product-card p {
            font-size: 14px;
            color: #666666;
            margin-bottom: 8px;
        }

        .product-card .price {
            font-size: 20px;
            font-weight: bold;
            color: #ff7f50;
            margin: 10px 0;
        }

        /* Estilos responsivos */
        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
            
            .tab-link {
                padding: 10px 15px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
            
            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <h1>Nuestros Productos</h1>
    <div class="tabs">
        <!-- Tabs de categorías -->
        <ul class="tab-list">
            <?php foreach ($productos_por_categoria as $categoria => $productos) : ?>
                <li class="tab-link" onclick="openTab('<?php echo $categoria; ?>')"><?php echo $categoria; ?></li>
            <?php endforeach; ?>
        </ul>
        <!-- Contenido de cada pestaña -->
        <?php foreach ($productos_por_categoria as $categoria => $productos) : ?>
            <div id="<?php echo $categoria; ?>" class="tab-content">
                <div class="product-grid">
                    <?php foreach ($productos as $producto) : ?>
                        <div class="product-card">
                            <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>">
                            <h3><?php echo $producto['nombre']; ?></h3>
                            <p><?php echo $producto['descripcion']; ?></p>
                            <p class="price">💲<?php echo number_format($producto['precio'], 2); ?></p>
                            <p>Stock: <?php echo $producto['stock']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <script>
        function openTab(tabName) {
            let tabs = document.querySelectorAll(".tab-content");
            let links = document.querySelectorAll(".tab-link");
            tabs.forEach(tab => tab.style.display = "none");
            links.forEach(link => link.classList.remove("active"));
            document.getElementById(tabName).style.display = "block";
            event.currentTarget.classList.add("active");
        }
        // Mostrar la primera pestaña al cargar
        document.addEventListener("DOMContentLoaded", function () {
            let firstTab = document.querySelector(".tab-link");
            if (firstTab) {
                firstTab.click();
            }
        });
    </script>
</body>
</html>