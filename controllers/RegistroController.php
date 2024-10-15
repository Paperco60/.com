<?php
require_once('../models/RegistroModel.php');
session_start();

// Mensajes de error
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre_completo'] ?? null;
    $documento = $_POST['documento'] ?? null;
    $telefono = $_POST['telefono'] ?? null;
    $correo = $_POST['correo'] ?? null;
    $password = $_POST['contrasena'] ?? null;

    // Verificar que todos los campos estén llenos
    if ($nombre && $documento && $telefono && $correo && $password) {
        $registroModel = new RegistroModel();
        $resultado = $registroModel->registrarUsuario($nombre, $documento, $telefono, $correo, $password);

        if ($resultado === true) {
            $_SESSION['usuario'] = ['correo' => $correo, 'rol' => 'cliente'];
            header("Location: ../views/panel_cliente.php");
            exit();
        } elseif ($resultado === 'correo') {
            $errorMessage = "Error: El correo ya está registrado. Vuelve a intentarlo.";
        } elseif ($resultado === 'documento') {
            $errorMessage = "Error: El documento ya está registrado. Vuelve a intentarlo.";
        } else {
            $errorMessage = "Error: No se pudo registrar el usuario.";
        }
    } else {
        $errorMessage = "Por favor, complete todos los campos.";
    }
}

// Incluye la vista de registro para mostrar el formulario y los mensajes de error
include '../views/registro.php';
