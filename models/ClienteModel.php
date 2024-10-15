<?php

class ClienteModel {
    private $db;

    public function __construct() {
        // Conexión a la base de datos
        $this->db = new PDO('mysql:host=localhost;dbname=bdproyect', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function obtenerPerfil($correo) {
        $sql = "SELECT nombre, documento, telefono, correo FROM cliente WHERE correo = :correo";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarPerfil($correo, $nuevaInformacion) {
        $sql = "UPDATE cliente SET nombre = :nombre, documento = :documento, telefono = :telefono WHERE correo = :correo";
        $stmt = $this->db->prepare($sql);
        
        // Asigna los parámetros
        $stmt->bindParam(':nombre', $nuevaInformacion['nombre']);
        $stmt->bindParam(':documento', $nuevaInformacion['documento']);
        $stmt->bindParam(':telefono', $nuevaInformacion['telefono']);
        $stmt->bindParam(':correo', $correo);
        
        return $stmt->execute();
    }
}
?>

