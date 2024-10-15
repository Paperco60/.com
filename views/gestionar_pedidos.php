<?php
require_once '../controllers/AdminPeController.php'; // Asegúrate de que la ruta sea correcta

// Manejo de las solicitudes
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new AdminPeController();
    $pedidos = $controller->mostrarPedidos(); // Obtén los pedidos
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos</title>
    <link rel="stylesheet" href="../public/css/pedidoa.css"> <!-- Asegúrate de que el CSS sea correcto -->
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
                 <li><a href="panel_admin.php">Panel</a></li>
                <li><a href="gestion_usuarios.php">Gestion de Usuarios</a></li>
                <li><a href="gestion_productos.php">Gestion de Productos</a></li>
                <li><a href="../index.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>

    <h1>Gestión de Pedidos</h1>
    <table>
        <thead>
            <tr>
                <th>Código del Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Correo</th>
                <th>Total</th>
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
                        <td><?php echo $pedido['correo']; ?></td>
                        <td><?php echo isset($pedido['Total']) ? $pedido['Total'] : 'N/A'; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No hay pedidos disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
</body>
</html>
