<?php
class AdminModel {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=bdproyect', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Para manejar errores
    }

    // Funciones relacionadas con clientes

    // Listar clientes
    public function listarClientes() {
        $query = "SELECT nombre, documento, telefono, correo FROM cliente";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Consultar cliente por correo
    public function consultarCliente($correo) {
        $query = "SELECT nombre, documento, telefono, correo FROM cliente WHERE correo = :correo";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Agregar cliente
    public function agregarCliente($nombre, $documento, $telefono, $correo, $contrasena) {
        $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);

        // Agregar a registro
        $stmt = $this->pdo->prepare("INSERT INTO registro (nombre, documento, telefono, correo, contrasena, rol) VALUES (:nombre, :documento, :telefono, :correo, :contrasena, 'cliente')");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':documento', $documento);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contrasena', $hashedPassword);
        $stmt->execute();

    }


}
?>
