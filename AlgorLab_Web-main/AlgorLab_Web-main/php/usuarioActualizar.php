<?php
include_once 'main.php';  // limpiarCadenas(), validarDatos(), conexion()

function actualizarUsuario($post, $userId) {
    $db = conexion();

    // Obtener datos actuales por ID
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$userId]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        return ['status' => 'error', 'msg' => 'Usuario no encontrado.'];
    }

    // Limpiar entradas del formulario
    $nombre      = limpiarCadenas($post['nombre'] ?? '');
    $apellidos   = limpiarCadenas($post['apellidos'] ?? '');
    $correoNuevo = limpiarCadenas($post['correo'] ?? '');
    $tratamiento = limpiarCadenas($post['tratamiento'] ?? '');
    
    $passActual  = limpiarCadenas($post['passActual'] ?? '');
    $nuevaPass1  = limpiarCadenas($post['nuevaPass1'] ?? '');
    $nuevaPass2  = limpiarCadenas($post['nuevaPass2'] ?? '');

    // Si el usuario rellenó todos los campos excepto la contraseña actual
    if (!empty($nombre) && !empty($apellidos) && !empty($correoNuevo) && !empty($tratamiento) && empty($passActual)) {
        return ['status' => 'error', 'msg' => 'Necesitas la contraseña actual para realizar cambios.'];
    }

    // Validaciones básicas de campos (ahora passActual ya no es obligatoria para pasar aquí)
    if (empty($nombre) || empty($apellidos) || empty($correoNuevo) || empty($tratamiento)) {
        return ['status' => 'error', 'msg' => 'Debe rellenar todos los campos obligatorios.'];
    }

    if (validarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{3,100}", $nombre)) {
        return ['status' => 'error', 'msg' => 'El nombre no cumple con el formato solicitado.'];
    }

    if (validarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{3,150}", $apellidos)) {
        return ['status' => 'error', 'msg' => 'Los apellidos no cumplen con el formato solicitado.'];
    }

    $tratamientosPermitidos = ['Masculino', 'Femenino', 'Otro'];
    if (!in_array($tratamiento, $tratamientosPermitidos)) {
        return ['status' => 'error', 'msg' => 'Tratamiento no válido.'];
    }

    // Validar y comprobar duplicado de correo si cambió
    if ($correoNuevo !== $userData['correo']) {
        if (!filter_var($correoNuevo, FILTER_VALIDATE_EMAIL)) {
            return ['status' => 'error', 'msg' => 'Correo electrónico no válido.'];
        }
        $checkEmail = $db->prepare("SELECT id FROM usuarios WHERE correo = ? AND id != ?");
        $checkEmail->execute([$correoNuevo, $userId]);
        if ($checkEmail->rowCount() > 0) {
            return ['status' => 'error', 'msg' => 'El correo electrónico ya está registrado por otro usuario.'];
        }
    }

    // Verificar contraseña actual si se va a cambiar contraseña o correo
    $cambiarPass = !empty($nuevaPass1) || !empty($nuevaPass2);
    if ($cambiarPass || $correoNuevo !== $userData['correo'] || $nombre !== $userData['nombre'] || $apellidos !== $userData['apellidos'] || $tratamiento !== $userData['tratamiento']) {
        // Requiere passActual
        if (empty($passActual) || !password_verify($passActual, $userData['contrasena'])) {
            return ['status' => 'error', 'msg' => 'Contraseña actual incorrecta o no proporcionada.'];
        }
    }

    // Manejo de cambio de contraseña (opcional)
    $passHash = $userData['contrasena'];
    if ($cambiarPass) {
        if (empty($nuevaPass1) || empty($nuevaPass2)) {
            return ['status' => 'error', 'msg' => 'Debe rellenar ambos campos de nueva contraseña.'];
        }
        if ($nuevaPass1 !== $nuevaPass2) {
            return ['status' => 'error', 'msg' => 'Las nuevas contraseñas no coinciden.'];
        }
        if (validarDatos("[a-zA-Z0-9$@.\-]{4,100}", $nuevaPass1)) {
            return ['status' => 'error', 'msg' => 'La nueva contraseña no cumple con el formato solicitado.'];
        }
        $passHash = password_hash($nuevaPass1, PASSWORD_BCRYPT, ['cost' => 10]);
    }

    // Ejecutar actualización
    $stmt = $db->prepare(
        "UPDATE usuarios SET nombre = ?, apellidos = ?, correo = ?, contrasena = ?, tratamiento = ? WHERE id = ?"
    );
    $exito = $stmt->execute([
        $nombre,
        $apellidos,
        $correoNuevo,
        $passHash,
        $tratamiento,
        $userId
    ]);

    if ($exito) {
        return [
            'status'     => 'success',
            'msg'        => 'Perfil actualizado correctamente.',
            'nuevoCorreo'=> $correoNuevo
        ];
    } else {
        return ['status' => 'error', 'msg' => 'Error al actualizar el perfil.'];
    }
}