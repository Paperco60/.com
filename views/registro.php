<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../public/css/registros.css">
    <link rel="icon" type="image/png" href="../public/images/paperco.png">
</head>
<body>
    <form action="../controllers/RegistroController.php" method="POST">
        <h2>Regístrate</h2>
        <img src="../public/images/paperco.png" alt="Logo Paperco" class="logo">

         <!-- Mensaje de error -->
    <?php if (!empty($errorMessage)): ?>
        <div class="error-message">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>
        
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

        <button type="submit">Registrar</button>
        <div class="button-container">
            <button type="button" class="small-button" onclick="window.location.href='../index.php'">Volver al inicio</button>
        </div>
    </form>
   
</body>
</html>
