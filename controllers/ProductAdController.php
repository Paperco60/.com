<?php
require_once(__DIR__ . '/../models/ProductoAdModel.php');

class ProductoAdController { // Corrige el nombre de la clase
    private $model;

    public function __construct() {
        $this->model = new ProductoAdModel(); // Cambié a ProductoAdModel
    }

    public function listarProductos() {
        return $this->model->listarProductos();
    }

    public function agregarProducto($codigo, $tipo, $precio, $productosDisponibles, $imagen) {
        // Verificar si el producto ya existe
        if ($this->model->productoExistente($codigo)) {
            return false; // El código de producto ya existe
        }
        return $this->model->agregarProducto($codigo, $tipo, $precio, $productosDisponibles, $imagen);
    }

    public function modificarProducto($id, $codigo, $tipo, $precio, $productosDisponibles, $imagen) {
        return $this->model->modificarProducto($id, $codigo, $tipo, $precio, $productosDisponibles, $imagen);
    }

    public function eliminarProducto($id) {
        return $this->model->eliminarProducto($id);
    }
}
?>
