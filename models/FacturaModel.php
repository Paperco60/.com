<?php
class FacturaModel {
    private $db;

    public function __construct() {
        // Conexión a la base de datos
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=bdproyect', 'root', '');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit();
        }
    }

    // Método para crear la factura a partir de un pedido
    public function crearFacturaDesdePedido($pedido_id, $correo_cliente) {
        // Obtener los detalles del pedido
        $pedido = $this->obtenerPedidoPorId($pedido_id, $correo_cliente);
        if ($pedido) {
            // Obtener los datos del cliente de la tabla registro
            $cliente = $this->obtenerClientePorCorreo($correo_cliente);
            if ($cliente) {
                // Insertar los datos en la tabla factura
                $sql = "INSERT INTO factura (pedido_id, nombre, documento, telefono, correo, Codigo_Producto, Cantidad, Precio, Imagen, Total) 
                        VALUES (:pedido_id, :nombre, :documento, :telefono, :correo, :Codigo_Producto, :Cantidad, :Precio, :Imagen, :Total)";
                $stmt = $this->db->prepare($sql);
                
                // Vincular los parámetros
                $stmt->bindParam(':pedido_id', $pedido_id);
                $stmt->bindParam(':nombre', $cliente['nombre']);
                $stmt->bindParam(':documento', $cliente['documento']);
                $stmt->bindParam(':telefono', $cliente['telefono']);
                $stmt->bindParam(':correo', $correo_cliente);
                $stmt->bindParam(':Codigo_Producto', $pedido['Codigo_Producto']);
                $stmt->bindParam(':Cantidad', $pedido['Cantidad']);
                $stmt->bindParam(':Precio', $pedido['Precio']);
                $stmt->bindParam(':Imagen', $pedido['Imagen']);
                $stmt->bindParam(':Total', $pedido['Total']);
                
                // Ejecutar la consulta
                $stmt->execute();

                // Devolver los detalles de la factura generada
                return array_merge($cliente, $pedido, ['correo' => $correo_cliente]);
            }
        }
        return false; // Si no se encontró el pedido o el cliente
    }

    // Obtener los detalles del pedido según el ID y el correo del cliente
    private function obtenerPedidoPorId($pedido_id, $correo_cliente) {
        $sql = "SELECT * FROM pedido WHERE ID = :pedido_id AND correo = :correo";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':pedido_id', $pedido_id);
        $stmt->bindParam(':correo', $correo_cliente);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener los detalles del cliente por su correo
    private function obtenerClientePorCorreo($correo) {
        $sql = "SELECT nombre, documento, telefono FROM registro WHERE correo = :correo";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
