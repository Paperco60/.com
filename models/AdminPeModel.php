<?php
class AdminPeModel {
    private $db;

    public function __construct() {
        // Conexión a la base de datos
        $this->db = new PDO('mysql:host=localhost;dbname=bdproyect', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function obtenerPedidos() {
        $query = "SELECT * FROM pedido"; // Asegúrate de que la consulta sea correcta
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
