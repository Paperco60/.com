<?php
class ProductoAdModel {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=bdproyect', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Para manejar errores
    }

    public function listarProductos() {
        $stmt = $this->pdo->query("SELECT * FROM inventario");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregarProducto($codigo, $tipo, $precio, $productosDisponibles, $imagen) {
        $stmt = $this->pdo->prepare("INSERT INTO inventario (Codigo_Producto, Tipo, Precio, productos_disponibles, Imagen) VALUES (:codigo, :tipo, :precio, :productos_disponibles, :imagen)");
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':productos_disponibles', $productosDisponibles);
        $stmt->bindParam(':imagen', $imagen);
        return $stmt->execute();
    }

    public function modificarProducto($id, $codigo, $tipo, $precio, $productosDisponibles, $imagen) {
        $stmt = $this->pdo->prepare("UPDATE inventario SET Codigo_Producto = :codigo, Tipo = :tipo, Precio = :precio, productos_disponibles = :productos_disponibles, Imagen = :imagen WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':productos_disponibles', $productosDisponibles);
        $stmt->bindParam(':imagen', $imagen);
        return $stmt->execute();
    }

    public function eliminarProducto($id) {
        $stmt = $this->pdo->prepare("DELETE FROM inventario WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    

    public function productoExistente($codigo) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM inventario WHERE Codigo_Producto = :codigo");
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
?>
