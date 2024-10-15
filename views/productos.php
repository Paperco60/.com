<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

require_once '../controllers/ProductoController.php';
$productoController = new ProductoController();
$productos = $productoController->listarProductos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="../public/css/compre.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/png" href="../public/images/paperco.png">
</head>
<body>
    <nav class="nav">
        <div class="nav-left">
            <div class="logo-container">
                <img src="../public/images/paperco.png" alt="Logotipo de Paperco" class="logo">
                <span class="company-name">Paperco</span>
            </div>
        </div>
        <div class="nav-right">
        <a href="panel_cliente.php">Panel</a>
            <a href="perfil.php">Ver Perfil</a>
            <a href="pedido.php">Mis Pedidos</a>
                
            <a href="#" id="carrito-icon" onclick="abrirVentanaEmergenteDesdeCarrito()">
                <i class="fas fa-shopping-cart carrito-icon"></i>
                <span id="carrito-count"><?php echo count($_SESSION['carrito']); ?></span>
            </a>
            <a href="../index.php">Cerrar Sesión</a>
        </div>
    </nav>

    <div class="container">
        <h1>Productos</h1>

        <div class="productos-container">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="producto-card">
                        <img src="../public/<?php echo $producto['Imagen']; ?>" alt="Imagen del Producto" class="producto-imagen">
                        <h2 class="producto-titulo"><?php echo $producto['Tipo']; ?></h2>
                        <p class="producto-codigo">Código: <?php echo $producto['Codigo_Producto']; ?></p>
                        <p class="producto-precio">Precio: $<?php echo $producto['Precio']; ?></p>
                        <p class="producto-disponibles">Disponibles: <?php echo $producto['productos_disponibles']; ?></p>
                        
                        <div class="botones-container">
                            <?php if ($producto['productos_disponibles'] > 0): ?>
                                <input type="number" id="cantidad_<?php echo $producto['Codigo_Producto']; ?>" name="cantidad" min="1" value="1" required>
                                <button class="btn btn-agregar" 
                                    onclick="agregarAlCarrito('<?php echo $producto['Codigo_Producto']; ?>', '<?php echo $producto['Tipo']; ?>', document.getElementById('cantidad_<?php echo $producto['Codigo_Producto']; ?>').value, '<?php echo $producto['Precio']; ?>', '<?php echo $producto['Imagen']; ?>')">
                                    Agregar al Carrito
                                </button>
                            <?php else: ?>
                                <p class="sin-stock">Producto agotado</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay productos disponibles.</p>
            <?php endif; ?>
        </div>
    </div>

    <div id="ventana-emergente" class="ventana-emergente" style="display:none;">
        <div class="contenido-ventana">
            <button class="btn-cerrar" onclick="cerrarVentana()">×</button>
            <h2>Carrito de Compras</h2>
            <div id="productos-en-carrito"></div>
            <button id="btn-confirmar" onclick="confirmarPedido()">Confirmar Pedido</button>
        </div>
    </div>

    <script src="../public/js/carrito.js"></script>
    

</body>
</html>
