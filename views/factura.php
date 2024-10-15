<?php
require_once '../controllers/FacturaController.php';

if (isset($_GET['pedido_id'])) {
    $pedido_id = $_GET['pedido_id'];
    $controller = new FacturaController();
    $facturaDetalles = $controller->generarFactura($pedido_id); // Genera la factura y obtiene detalles
} else {
    echo "ID de pedido no especificado.";
    exit; // Salir si no hay ID de pedido
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <link rel="stylesheet" href="../public/css/factura.css"> <!-- Enlace al archivo CSS -->
    <link rel="icon" type="image/png" href="../public/images/paperco.png">
</head>
<body>
    <div class="container">
        <div class="factura">
            <div class="header">
                <img src="../public/images/paperco.png" alt="Logotipo de Paperco" class="logo"> <!-- Cambia la ruta según la ubicación de tu logo -->
                <h1 class="empresa">Paperco</h1>
            </div>
            <hr>
            <h2>Factura Generada</h2>
            <?php if (isset($facturaDetalles) && !empty($facturaDetalles)): ?>
                <div class="datos-factura">
                    <div class="datos-left">
                        <h3><?php echo $facturaDetalles['nombre']; ?></h3>
                    </div>
                    <div class="datos-right">
                        <p><strong>Teléfono:</strong> <?php echo $facturaDetalles['telefono']; ?></p>
                        <p><strong>Correo:</strong> <?php echo $facturaDetalles['correo']; ?></p>
                    </div>
                </div>
                <p><strong>Documento:</strong> <?php echo $facturaDetalles['documento']; ?></p>
                <hr>
                <h3>Detalles del Pedido</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Código</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><img src="../public/<?php echo $facturaDetalles['Imagen']; ?>" alt="Producto" style="width: 50px; height: 50px;"></td>
                            <td><?php echo $facturaDetalles['Codigo_Producto']; ?></td>
                            <td><?php echo $facturaDetalles['Cantidad']; ?></td>
                            <td><?php echo $facturaDetalles['Precio']; ?></td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <p><strong>Total:</strong> <?php echo $facturaDetalles['Total']; ?></p>
            <?php else: ?>
                <p>No se pudo generar la factura. Por favor verifica que el pedido y los datos del cliente sean correctos.</p>
            <?php endif; ?>
        </div>

        <!-- Botón para volver a la página deseada -->
        <a href="../views/pedido.php" class="btn">Volver atrás</a> <!-- Cambia la ruta a la página deseada -->
   
        <!-- Botón de cerrar sesión -->
        <a href="../index.php" class="btn">Cerrar sesión</a> <!-- Cambia la ruta según tu lógica de cierre de sesión -->
    </div>
</body>
</html>
