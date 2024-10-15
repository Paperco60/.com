<?php
require_once '../models/FacturaModel.php';

class FacturaController {
    private $modelo;

    public function __construct() {
        $this->modelo = new FacturaModel();
    }

    public function generarFactura($pedido_id) {
        session_start();
        if (isset($_SESSION['usuario'])) {
            $correo_cliente = $_SESSION['usuario']['correo'];
            return $this->modelo->crearFacturaDesdePedido($pedido_id, $correo_cliente);
        } else {
            throw new Exception("Debe iniciar sesión para generar una factura.");
        }
    }
}
?>
