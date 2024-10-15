<?php

require_once '../models/ProductoModel.php';

class ProductoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new ProductoModel();
    }

    public function listarProductos() {
        return $this->modelo->obtenerProductos();
    }

    public function agregarPedido() {
        session_start();
        if (isset($_SESSION['usuario'])) {
            $correo_cliente = $_SESSION['usuario']['correo'];
            $productos = json_decode($_POST['productos'], true);

            if (empty($productos)) {
                echo "No hay productos para procesar el pedido.";
                return;
            }

            $totalPedido = 0; // Inicializamos el total

            foreach ($productos as $producto) {
                // Verificamos la disponibilidad del producto antes de calcular el subtotal
                if (!$this->modelo->verificarDisponibilidad($producto['codigo'], $producto['cantidad'])) {
                    echo "No hay suficiente stock disponible para el producto " . $producto['codigo'] . ".";
                    return;
                }

                $subtotal = $producto['precio'] * $producto['cantidad']; // Calculamos el subtotal
                $totalPedido += $subtotal; // Sumamos al total

                try {
                    // Agregar el pedido
                    $this->modelo->agregarPedido([
                        'Codigo_Producto' => $producto['codigo'],
                        'Cantidad' => $producto['cantidad'],
                        'Precio' => $producto['precio'],
                        'Correo' => $correo_cliente,
                        'Imagen' => $producto['imagen'],
                        'Total' => $subtotal // Pasamos el subtotal
                    ]);
                } catch (Exception $e) {
                    echo "Error al realizar el pedido: " . $e->getMessage();
                    return;
                }
            }

            echo "Pedido realizado con éxito.";
        } 
    }
}

// Manejo de las solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ProductoController();
    $controller->agregarPedido();
}
