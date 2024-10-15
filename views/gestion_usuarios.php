<?php
session_start(); // Iniciar la sesión al principio

require_once '../controllers/AdminController.php'; // Asegúrate de que la ruta sea correcta

$controller = new AdminController();
$clientes = $controller->listarClientes();
$clienteEncontrado = null;
$mensaje = ''; // Variable para mensajes de feedback

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar'])) {
        $nombreCompleto = $_POST['nombre_completo'];
        $documento = $_POST['documento'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena'];

        // Agregar el cliente y manejar el feedback
        try {
            $controller->agregarCliente($nombreCompleto, $documento, $telefono, $correo, $contrasena);
            $mensaje = 'Cliente agregado con éxito.';
        } catch (Exception $e) {
            $mensaje = 'Error al agregar el cliente: ' . $e->getMessage();
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } elseif (isset($_POST['consultar'])) {
        $correoConsulta = $_POST['correoConsulta'];
        $clienteEncontrado = $controller->consultarCliente($correoConsulta);
        if (!$clienteEncontrado) {
            $mensaje = 'No se encontró el cliente.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../public/css/usuariios.css"> 
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
            <a href="panel_admin.php">Panel</a>
            <a href="gestion_productos.php" class="logout"> Gestion de Productos</a>
            <a href="gestionar_pedidos.php" class="logout"> Gestion de Pedidos</a>
            <a href="../index.php" class="logout">Cerrar Sesión</a>
        </div>
    </nav>

    <!-- Contenido de gestión de usuarios -->
    <div class="container">
        <div class="form-container">
            <h1>Agregar Cliente</h1>
            <form method="POST">
                <label for="nombre_completo">Nombre completo:</label>
                <input type="text" name="nombre_completo" id="nombre_completo" required>

                <label for="documento">Documento:</label>
                <input type="text" name="documento" id="documento" required maxlength="10" pattern="\d{10}" title="El documento debe tener exactamente 10 dígitos.">

                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" id="telefono" required maxlength="10" pattern="\d{10}" title="El teléfono debe tener exactamente 10 dígitos.">
                
                <label for="correo">Correo:</label>
                <input type="email" name="correo" id="correo" required>

                <label for="contrasena">Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena" required>

                <button type="submit" name="agregar">Agregar Cliente</button>
            </form>
        </div>

        <div class="form-container">
            <h1>Consultar Cliente</h1>
            <!-- Mensaje de feedback -->
            <?php if ($mensaje): ?>
                <div class="mensaje">
                    <?= $mensaje ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <label for="correoConsulta">Correo del cliente:</label>
                <input type="email" name="correoConsulta" id="correoConsulta" required>
                <button type="submit" name="consultar">Consultar</button>
            </form>
        </div>

        <?php if ($clienteEncontrado): ?>
            <h2>Cliente Encontrado:</h2>
            <p>Nombre: <?= $clienteEncontrado['nombre'] ?></p>
            <p>Documento: <?= $clienteEncontrado['documento'] ?></p>
            <p>Teléfono: <?= $clienteEncontrado['telefono'] ?></p>
            <p>Correo: <?= $clienteEncontrado['correo'] ?></p>
        <?php endif; ?>

        <div class="table-container">
            <h1>Lista de Clientes</h1>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?= $cliente['nombre'] ?></td>
                            <td><?= $cliente['documento'] ?></td>
                            <td><?= $cliente['telefono'] ?></td>
                            <td><?= $cliente['correo'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
</body>
</html>
