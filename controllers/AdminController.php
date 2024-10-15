<?php
require_once(__DIR__ . '/../models/AdminModel.php');

class AdminController {
    private $model;

    public function __construct() {
        $this->model = new AdminModel();
    }

    // Funciones relacionadas con clientes

    public function listarClientes() {
        return $this->model->listarClientes();
    }

    public function consultarCliente($correo) {
        return $this->model->consultarCliente($correo);
    }

    public function agregarCliente($nombre, $documento, $telefono, $correo, $contrasena) {
        // Aquí puedes agregar validaciones y otras lógicas
        $this->model->agregarCliente($nombre, $documento, $telefono, $correo, $contrasena);
    }

}
?>
