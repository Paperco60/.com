<?php
require_once '../models/PedidoModel.php';

class PedidoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new PedidoModel();
    }

    public function listarPedidos() {
        session_start();
        if (isset($_SESSION['usuario'])) {
            $correo_cliente = $_SESSION['usuario']['correo'];
            return $this->modelo->obtenerPedidosPorCorreo($correo_cliente);
        } else {
            throw new Exception("Debe iniciar sesión para ver sus pedidos.");
        }
    }

    public function borrarPedido($id) {
        session_start();
        if (isset($_SESSION['usuario'])) {
            $correo_cliente = $_SESSION['usuario']['correo'];
            return $this->modelo->borrarPedido($id, $correo_cliente);
        } else {
            throw new Exception("Debe iniciar sesión para borrar un pedido.");
        }
    }
}

// Manejo de las solicitudes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrar_id'])) {
    $controller = new PedidoController();
    $controller->borrarPedido($_POST['borrar_id']);
    header('Location: pedido.php'); // Redirigir a la vista de pedidos
    exit();
}
?>

