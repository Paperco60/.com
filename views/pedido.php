<?php
require_once '../controllers/PedidoController.php';

$controller = new PedidoController();
$pedidos = $controller->listarPedidos(); // Obtiene los pedidos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos</title>
    <link rel="stylesheet" href="../public/css/pedidocli.css"> <!-- Enlace al archivo CSS -->
    <link rel="icon" type="image/png" href="../public/images/paperco.png">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="nav">
        <div class="nav-left">
            <div class="logo-container">
                <img src="../public/images/paperco.png" alt="Logotipo de Paperco" class="logo"> <!-- Logotipo -->
                <span class="company-name">Paperco</span> <!-- Nombre de la empresa -->
            </div>
        </div>

        <div class="nav-right">
            <ul class="nav-links">
                <li><a href="panel_cliente.php">Panel</a></li>
                <li><a href="perfil.php">Ver Perfil</a></li> <!-- Enlace a Perfil -->
                <li><a href="productos.php">Productos</a></li> <!-- Enlace a Productos -->
                <li><a href="../index.php">Cerrar Sesión</a></li> <!-- Enlace de Cerrar Sesión -->
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1>Mis Pedidos</h1>
        <table>
            <thead>
                <tr>
                    <th>Código del Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Total</th>
                    <th>Acciones</th> <!-- Nueva columna para acciones -->
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pedidos)): ?>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?php echo $pedido['Codigo_Producto']; ?></td>
                            <td><?php echo $pedido['Cantidad']; ?></td>
                            <td><?php echo $pedido['Precio']; ?></td>
                            <td>
                                <img src="../public/<?php echo $pedido['Imagen']; ?>" alt="Producto" style="width: 50px; height: 50px;">
                            </td>
                            <td><?php echo isset($pedido['Total']) ? $pedido['Total'] : 'N/A'; ?></td>
                            <td>
                                <!-- Botón para mostrar factura -->
                                <a href="factura.php?pedido_id=<?php echo $pedido['ID']; ?>" class="btn-factura">Mostrar Factura</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No hay pedidos disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
