<?php

class ProductoModel {
    private $db;

    public function __construct() {
        // Conexión a la base de datos
        $this->db = new PDO('mysql:host=localhost;dbname=bdproyect', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function obtenerProductos() {
        $sql = "SELECT * FROM inventario";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregarPedido($pedido) {
        // Primero, verificamos la disponibilidad antes de guardar el pedido
        if ($this->verificarDisponibilidad($pedido['Codigo_Producto'], $pedido['Cantidad'])) {
            // Ahora, guardamos el pedido en la base de datos
            $sql = "INSERT INTO pedido (Codigo_Producto, Cantidad, Precio, Imagen, Correo, Total) 
                    VALUES (:codigo_producto, :cantidad, :precio, :imagen, :correo, :total)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':codigo_producto', $pedido['Codigo_Producto']);
            $stmt->bindParam(':cantidad', $pedido['Cantidad']);
            $stmt->bindParam(':precio', $pedido['Precio']);
            $stmt->bindParam(':imagen', $pedido['Imagen']);
            $stmt->bindParam(':correo', $pedido['Correo']);
            $stmt->bindParam(':total', $pedido['Total']);
            $stmt->execute();
        } else {
            throw new Exception("No hay suficientes productos disponibles.");
        }
    }

    public function verificarDisponibilidad($codigoProducto, $cantidad) {
        $sql = "SELECT productos_disponibles FROM inventario WHERE Codigo_Producto = :codigo_producto";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':codigo_producto', $codigoProducto);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado && $resultado['productos_disponibles'] >= $cantidad;
    }
}
