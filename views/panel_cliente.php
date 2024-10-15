<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'cliente') {
    header("Location: ../views/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cliente</title>
    <link rel="stylesheet" href="../public/css/cliente.css">
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
                <li><a href="perfil.php">Ver Perfil</a></li> <!-- Enlace a Perfil -->
                <li><a href="pedido.php">Mis Pedidos</a></li> <!-- Enlace a Pedidos -->
                <li><a href="productos.php">Productos</a></li> <!-- Enlace a Productos -->
                <li><a href="../index.php">Cerrar Sesión</a></li> <!-- Enlace de Cerrar Sesión -->
            </ul>
        </div>
    </nav>

    <!-- Contenido del panel de cliente -->
    <div class="container">
        <h2>Bienvenido al Panel de Cliente</h2>
        <p>Aquí puedes ver tus pedidos, productos y gestionar tu cuenta.</p>
    </div>

    
</body>
</html>
