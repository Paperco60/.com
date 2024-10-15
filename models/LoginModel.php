<?php

class LoginModel {
    private $db;

    public function __construct() {
        // Configuración de la conexión a la base de datos
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=bdproyect', 'root', '');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error al conectar con la base de datos: " . $e->getMessage();
            exit();
        }
    }

    // Verificar si el correo y la contraseña son correctos
    public function verificarUsuario($correo, $contrasena) {
        $sql = "SELECT Correo, Contrasena, Rol FROM inicio_sesion WHERE Correo = :correo";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si el usuario existe y la contraseña es válida
        if ($usuario && password_verify($contrasena, $usuario['Contrasena'])) {
            return $usuario;
        }

        return false; // Si no coincide el correo o contraseña, retorna false
    }
}
