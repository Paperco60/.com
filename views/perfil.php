<?php
session_start();
require_once '../controllers/ClienteController.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$correo = $_SESSION['usuario']['correo'];
$clienteController = new ClienteController();
$perfil = $clienteController->perfil($correo);

// Verifica si se encontró el perfil
if (!$perfil) {
    echo "<h2>Perfil no encontrado</h2>";
    exit();
}

// Manejo del formulario para actualizar el perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevaInformacion = [
        'nombre' => $_POST['nombre'], 
        'documento' => $_POST['documento'], 
        'telefono' => $_POST['telefono']
    ];

    // Actualiza el perfil y redirige o muestra un error
    if ($clienteController->actualizarPerfil($correo, $nuevaInformacion)) {
        header("Location: perfil.php");
        exit();
    } else {
        echo "<h2 class='error-message'>Error al actualizar el perfil</h2>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil del Cliente</title>
    <link rel="stylesheet" href="../public/css/perfill.css"> <!-- Enlace al archivo CSS -->
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
                <li><a href="pedido.php">Mis Pedidos</a></li> <!-- Enlace a Pedidos -->
                <li><a href="productos.php">Productos</a></li> <!-- Enlace a Productos -->
                <li><a href="../index.php">Cerrar Sesión</a></li> <!-- Enlace de Cerrar Sesión -->
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1>Perfil de <?php echo $perfil['nombre']; ?></h1>

        <form method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="" required> <!-- Campo vacío -->

            <label for="documento">Documento:</label>
            <input type="text" name="documento" id="documento" value="" required maxlength="10" pattern="\d{10}"> <!-- Campo vacío -->

            <label for="telefono">Teléfono:</label>
            <input type="tel" name="telefono" id="telefono" value="" required maxlength="10" pattern="\d{10}"> <!-- Campo vacío -->

            <button type="submit">Actualizar Perfil</button>
        </form>
    </div>
</body>
</html>

</html>

