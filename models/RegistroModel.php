<?php
class RegistroModel {
    private $db;

    public function __construct() {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=bdproyect', 'root', '');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "No se pudo conectar a la base de datos: " . $e->getMessage();
            exit();
        }
    }

    public function registrarUsuario($nombre, $documento, $telefono, $correo, $password) {
        try {
            // Verificar si el correo ya está registrado
            $sqlCheckEmail = "SELECT * FROM registro WHERE Correo = :correo";
            $stmtCheckEmail = $this->db->prepare($sqlCheckEmail);
            $stmtCheckEmail->bindParam(':correo', $correo);
            $stmtCheckEmail->execute();

            if ($stmtCheckEmail->rowCount() > 0) {
                return 'correo'; // Correo ya registrado
            }

            // Verificar si el documento ya está registrado
            $sqlCheckDocumento = "SELECT * FROM registro WHERE Documento = :documento";
            $stmtCheckDocumento = $this->db->prepare($sqlCheckDocumento);
            $stmtCheckDocumento->bindParam(':documento', $documento);
            $stmtCheckDocumento->execute();

            if ($stmtCheckDocumento->rowCount() > 0) {
                return 'documento'; // Documento ya registrado
            }

            // Si todo está bien, registrar el usuario
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $this->db->beginTransaction();

            $sqlRegistro = "INSERT INTO registro (Nombre, Documento, Telefono, Correo, Contrasena, Rol) 
                            VALUES (:nombre, :documento, :telefono, :correo, :password, 'cliente')";
            $stmtRegistro = $this->db->prepare($sqlRegistro);
            $stmtRegistro->bindParam(':nombre', $nombre);
            $stmtRegistro->bindParam(':documento', $documento);
            $stmtRegistro->bindParam(':telefono', $telefono);
            $stmtRegistro->bindParam(':correo', $correo);
            $stmtRegistro->bindParam(':password', $hashedPassword);
            $stmtRegistro->execute();

            $this->db->commit();
            return true; // Registro exitoso
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false; // Error general
        }
    }
}
