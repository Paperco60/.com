<?php
session_start();
require_once("../models/LoginModel.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitiza las entradas para evitar problemas de seguridad
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $contrasena = htmlspecialchars($_POST['contrasena'], ENT_QUOTES, 'UTF-8');

    $modelo = new LoginModel();
    $usuario = $modelo->verificarUsuario($correo, $contrasena);

    if ($usuario) {
        $_SESSION['usuario'] = [
            'correo' => $usuario['Correo'],
            'rol' => $usuario['Rol']
        ];

        // Redirige al panel correspondiente según el rol
        if ($usuario['Rol'] === 'cliente') {
            header("Location: ../views/panel_cliente.php");
        } else {
            header("Location: ../views/panel_admin.php");
        }
        exit();
    } else {
        $error = "Correo o contraseña incorrectos.";
        include("../views/login.php");
    }
} else {
    include("../views/login.php");
}

