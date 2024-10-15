<?php
require_once '../models/AdminPeModel.php'; // Asegúrate de que la ruta sea correcta

class AdminPeController {
    private $modelo;

    public function __construct() {
        $this->modelo = new AdminPeModel(); // Inicializa el modelo
    }

    // Método para listar pedidos
    public function listarPedidos() {
        return $this->modelo->obtenerPedidos(); // Llama al método del modelo
    }

    // Método para mostrar pedidos
    public function mostrarPedidos() {
        $pedidos = $this->listarPedidos(); // Obtener los pedidos
        return $pedidos; // Retorna los pedidos para ser utilizados en la vista
    }
}

// Manejo de las solicitudes
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new AdminPeController();
    $pedidos = $controller->mostrarPedidos(); // Llama al método que muestra los pedidos
}
?>
