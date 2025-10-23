<?php
function procesarRecuperar() {
    // Asumimos sesión iniciada y main cargado
    $correo      = trim($_POST['correo']      ?? '');
    $codigo      = trim($_POST['codigo']      ?? '');
    $nuevaPass1  = trim($_POST['nuevaPass1']  ?? '');
    $nuevaPass2  = trim($_POST['nuevaPass2']  ?? '');

    // Respuesta por defecto
    $res = [
        'status'   => 'error',
        'msg'      => 'Ha ocurrido un error.',
        'redirect' => false
    ];

    // Validaciones...
    if (
        !filter_var($correo, FILTER_VALIDATE_EMAIL) ||
        $codigo === '' ||
        $nuevaPass1 === '' ||
        $nuevaPass2 === ''
    ) {
        $res['msg'] = 'Completa todos los campos correctamente.';
        return $res;
    }
    if ($nuevaPass1 !== $nuevaPass2) {
        $res['msg'] = 'Las contraseñas no coinciden.';
        return $res;
    }
    if (validarDatos("[a-zA-Z0-9\$@.\-]{4,100}", $nuevaPass1)) {
        $res['msg'] = 'La nueva contraseña no cumple con el formato requerido.';
        return $res;
    }

    // Comprobar en BD
    $db = conexion();
    $stmt = $db->prepare("
        SELECT id 
          FROM usuarios 
         WHERE correo = :correo 
           AND cod_recuperacion = :codigo
         LIMIT 1
    ");
    $stmt->execute([
        ':correo' => $correo,
        ':codigo' => $codigo
    ]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $res['msg'] = 'Correo o código incorrecto.';
        return $res;
    }

    $upd = $db->prepare("
        UPDATE usuarios
           SET contrasena = :pass
         WHERE id = :id
    ");
    $ok = $upd->execute([
        ':pass' => $nuevaPass1,
        ':id'   => $user['id']
    ]);

    if ($ok) {
        $res['status']   = 'success';
        $res['msg']      = 'Contraseña restablecida correctamente.';
        $res['redirect'] = true;
    } else {
        $res['msg'] = 'Error al actualizar la contraseña.';
    }

    return $res;
}