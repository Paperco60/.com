<?php
require_once __DIR__ . '/../models/ClienteModel.php';

class ClienteController {
    private $clienteModel;

    public function __construct() {
        $this->clienteModel = new ClienteModel();
    }

    public function perfil($correo) {
        return $this->clienteModel->obtenerPerfil($correo);
    }

    public function actualizarPerfil($correo, $nuevaInformacion) {
        return $this->clienteModel->actualizarPerfil($correo, $nuevaInformacion);
    }
}
?>
