<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'administrador') {
    header("Location: ../views/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/admini.css"> <!-- Vincula el CSS -->
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
                <li><a href="gestion_usuarios.php">Usuarios</a></li>
                <li><a href="gestion_productos.php">Productos</a></li>
                <li><a href="gestionar_pedidos.php">Pedidos</a></li>
                <li><a href="../index.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>

    <!-- Contenido del panel de administrador -->
    <div class="container">
        <h2>Bienvenido al Panel de Administrador</h2>
        <p>Desde aquí puedes gestionar usuarios y productos.</p>
    </div>
</body>
</html>
