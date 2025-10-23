<?php
// php/iniciarSesion.php

function iniciarSesion() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Limpieza de cadenas antes de validar
    $correo = limpiarCadenas($_POST['loginCorreo'] ?? '');
    $pass   = limpiarCadenas($_POST['loginPass']   ?? '');

    // Verificar campos obligatorios
    if ($correo === "" || $pass === "") {
        return [
            'msg'    => 'No has completado todos los campos obligatorios.',
            'status' => 'error'
        ];
    }

    // Validar formato de correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        return [
            'msg'    => 'El correo no tiene un formato válido.',
            'status' => 'error'
        ];
    }

    // Validar formato de contraseña
    if (validarDatos("[a-zA-Z0-9\$@.\-]{4,100}", $pass)) {
        return [
            'msg'    => 'La contraseña no cumple el formato solicitado.',
            'status' => 'error'
        ];
    }

    // Comprobar en la base de datos
    $pdo       = conexion();
    $checkUser = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $checkUser->execute([$correo]);

    if ($checkUser->rowCount() === 1) {
        $userData = $checkUser->fetch(PDO::FETCH_ASSOC);

        if ($userData['contrasena'] === $pass) {
            $_SESSION['usuario_id']    = $userData['id'];
            $_SESSION['usuario_email'] = $userData['correo'];

            return [
                'msg'      => 'Has iniciado sesión correctamente.',
                'status'   => 'success',
                'redirect' => true
            ];
        } else {
            return [
                'msg'    => 'Correo o contraseña incorrectos.',
                'status' => 'error'
            ];
        }
    } else {
        return [
            'msg'    => 'Correo o contraseña incorrectos.',
            'status' => 'error'
        ];
    }
}