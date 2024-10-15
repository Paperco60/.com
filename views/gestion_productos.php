<?php
require_once '../controllers/ProductAdController.php';
$controller = new ProductoAdController(); // Asegúrate de usar el nombre correcto

// Obtener la lista de productos
$productos = $controller->listarProductos();

// Manejo del formulario para agregar, modificar y eliminar productos
$error = ''; // Variable para almacenar errores
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Agregar producto
    if (isset($_POST['agregar'])) {
        if (isset($_POST['codigo']) && isset($_POST['tipo']) && isset($_POST['precio']) && isset($_POST['productos_disponibles']) && isset($_FILES['imagen'])) {
            // Subir imagen
            $imagen = 'uploads/' . basename($_FILES['imagen']['name']);
            move_uploaded_file($_FILES['imagen']['tmp_name'], '../public/' . $imagen);
            
            // Intentar agregar el producto
            if (!$controller->agregarProducto($_POST['codigo'], $_POST['tipo'], $_POST['precio'], $_POST['productos_disponibles'], $imagen)) {
                $error = 'El código de producto ya existe. Por favor, utiliza otro código.';
            } else {
                header('Location: gestion_productos.php'); // Redirigir después de agregar
                exit();
            }
        }
    }

    // Eliminar producto
    if (isset($_POST['eliminar'])) {
        $controller->eliminarProducto($_POST['id']);
        header('Location: gestion_productos.php'); // Redirigir después de eliminar
        exit();
    }

    // Modificar producto
    if (isset($_POST['modificar'])) {
        if (isset($_POST['id']) && isset($_POST['codigo']) && isset($_POST['tipo']) && isset($_POST['precio']) && isset($_POST['productos_disponibles'])) {
            $imagen = $_POST['imagen']; // Mantener la imagen actual si no se sube una nueva
            if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] == 0) {
                // Subir nueva imagen
                $imagen = 'uploads/' . basename($_FILES['nueva_imagen']['name']);
                move_uploaded_file($_FILES['nueva_imagen']['tmp_name'], '../public/' . $imagen);
            }
            $controller->modificarProducto($_POST['id'], $_POST['codigo'], $_POST['tipo'], $_POST['precio'], $_POST['productos_disponibles'], $imagen);
            header('Location: gestion_productos.php'); // Redirigir después de modificar
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="../public/css/productos.css">
    <link rel="icon" type="image/png" href="../public/images/paperco.png">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="nav">
        <div class="nav-left">
            <div class="logo-container">
                <img src="../public/images/paperco.png" alt="Logotipo de Paperco" class="logo">
                <span class="company-name">Paperco</span>
            </div>
        </div>

        <div class="nav-right">
            <a href="panel_admin.php" class="logout">Panel</a>
            <a href="gestion_usuarios.php" class="logout"> Gestion de Usuarios</a>
            <a href="gestionar_pedidos.php" class="logout">Gestion de Pedidos</a>
            <a href="../index.php" class="logout">Cerrar Sesión</a>
        </div>
    </nav>

    <div class="container">
        <h1>Gestión de Productos</h1>

        <!-- Mensaje de error si existe -->
        <?php if ($error): ?>
            <div class="error-message">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Formulario para agregar productos -->
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="codigo" placeholder="Código de Producto" required>
            <input type="text" name="tipo" placeholder="Tipo de Producto" required>
            <input type="number" step="0.01" name="precio" placeholder="Precio" required>
            <input type="number" name="productos_disponibles" placeholder="Productos Disponibles" required>
            <input type="file" name="imagen" required style="width: 100%;">
            <button type="submit" name="agregar" class="button">Agregar</button>
        </form>
    </div>

    <!-- Contenedor separado para la tabla -->
    <div class="table-container">
        <h2>Lista de Productos</h2>

        <!-- Tabla de productos -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Tipo</th>
                    <th>Precio</th>
                    <th>Productos Disponibles</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo $producto['ID']; ?></td>
                            <td><?php echo $producto['Codigo_Producto']; ?></td>
                            <td><?php echo $producto['Tipo']; ?></td>
                            <td><?php echo $producto['Precio']; ?></td>
                            <td><?php echo $producto['productos_disponibles']; ?></td>
                            <td>
                                <?php
                                $imagenPath = '../public/' . $producto['Imagen'];
                                ?>
                                <img src="<?php echo $imagenPath; ?>" alt="Imagen del Producto" style="width:100px;height:100px;">
                            </td>
                            <td>
                                <!-- Formulario para modificar y eliminar productos -->
                                <form method="POST" style="display: flex; align-items: center;" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $producto['ID']; ?>">
                                    <input type="hidden" name="imagen" value="<?php echo $producto['Imagen']; ?>">
                                    <input type="text" name="codigo" value="<?php echo $producto['Codigo_Producto']; ?>" required>
                                    <input type="text" name="tipo" value="<?php echo $producto['Tipo']; ?>" required>
                                    <input type="number" step="0.01" name="precio" value="<?php echo $producto['Precio']; ?>" required>
                                    <input type="number" name="productos_disponibles" value="<?php echo $producto['productos_disponibles']; ?>" required>
                                    <input type="file" name="nueva_imagen" style="width: 100%;">
                                    <button type="submit" name="modificar" class="button">Modificar</button>
                                    <button type="submit" name="eliminar" class="button" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No hay productos disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>
