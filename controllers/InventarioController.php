<?php
require_once 'InventarioModel.php';

class InventarioController {
    private $model;

    public function __construct() {
        $this->model = new InventarioModel();
    }

    public function mostrarInventario() {
        $productos = $this->model->obtenerProductos();
        include 'inventarioView.php'; // Asegúrate de tener un archivo de vista
    }
}

// Crear una instancia del controlador y mostrar el inventario
$controller = new InventarioController();
$controller->mostrarInventario();
?>
