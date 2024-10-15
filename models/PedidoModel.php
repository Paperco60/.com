<?php
class PedidoModel {
    private $db;

    public function __construct() {
        // Conexión a la base de datos
        $this->db = new PDO('mysql:host=localhost;dbname=bdproyect', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function obtenerPedidosPorCorreo($correo) {
        $sql = "SELECT * FROM pedido WHERE correo = :correo"; // Asegúrate de que el nombre de la tabla sea correcto
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function borrarPedido($id, $correo) {
        $sql = "DELETE FROM pedido WHERE ID = :id AND correo = :correo"; // Asegúrate de que el nombre de la tabla sea correcto
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':correo', $correo);
        return $stmt->execute();
    }
}
?>
