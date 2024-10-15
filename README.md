<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Paperco</title>
    <link rel="stylesheet" href="public/css/inde.css"> <!-- Asegúrate de tener este archivo CSS -->
    <link rel="icon" type="image/png" href="public/images/paperco.png">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="nav">
        <div class="nav-left">
            <div class="logo-container">
                <img src="public/images/paperco.png" alt="Logotipo de Paperco" class="logo">
                <span class="company-name">Paperco</span>
            </div>
        </div>

        <div class="nav-right">
            <ul class="nav-links">
                <li><a href="views/registro.php">Registro</a></li>
                <li><a href="views/login.php">Login</a></li>
            </ul>
        </div>
    </nav>

    <!-- Imagen de papelería -->
    <div class="hero">
        <img src="public/images/papee.png" alt="Papelería" class="hero-image"> <!-- Cambia la ruta según tu imagen -->
    </div>

    <!-- Botón de compra -->
    <div class="buy-section">
        <h2>¿Listo para comprar?</h2>
        <p>Inicia sesión para acceder a nuestros productos y ofertas exclusivas.</p>
        <a href="views/login.php" class="btn">Iniciar Sesión</a>
    </div>

    <footer>
        <p>&copy; 2024 Paperco. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
