<?php
function obtenerMensajeRegistro()
{
    require_once "main.php";

    $nombre       = limpiarCadenas($_POST['usuarioNombre']    ?? '');
    $apellidos    = limpiarCadenas($_POST['usuarioApellidos'] ?? '');
    $correo       = limpiarCadenas($_POST['usuarioCorreo']    ?? '');
    $tratamiento  = limpiarCadenas($_POST['usuarioTratamiento'] ?? '');
    $pass1        = limpiarCadenas($_POST['usuarioPass1']     ?? '');
    $pass2        = limpiarCadenas($_POST['usuarioPass2']     ?? '');

    // Validaciones
    if (!$nombre || !$apellidos || !$correo || !$tratamiento || !$pass1 || !$pass2) {
        return ['status'=>'error','msg'=>'Todos los campos obligatorios deben completarse.'];
    }
    if (validarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,100}", $nombre)) {
        return ['status'=>'error','msg'=>'Nombre no válido.'];
    }
    if (validarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,150}", $apellidos)) {
        return ['status'=>'error','msg'=>'Apellidos no válidos.'];
    }
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        return ['status'=>'error','msg'=>'Correo no válido.'];
    }
    $opc = ['Masculino','Femenino','Otro'];
    if (!in_array($tratamiento,$opc)) {
        return ['status'=>'error','msg'=>'Tratamiento no válido.'];
    }
    if ($pass1 !== $pass2) {
        return ['status'=>'error','msg'=>'Las contraseñas no coinciden.'];
    }
    if (validarDatos("[a-zA-Z0-9\$@.\-]{4,100}", $pass1)) {
        return ['status'=>'error','msg'=>'La contraseña no cumple el formato.'];
    }

    // Duplicados
    $db = conexion();
    $chk = $db->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $chk->execute([$correo]);
    if ($chk->rowCount()>0) {
        return ['status'=>'error','msg'=>'Este correo ya está registrado.'];
    }

    // Preparar inserción
    $codigo = str_pad(rand(0,999999),6,'0',STR_PAD_LEFT);
    $contrasena = $pass1;

    $sql = "INSERT INTO usuarios
              (nombre, apellidos, correo, contrasena, tratamiento, cod_recuperacion)
            VALUES
              (:n, :a, :c, :p, :t, :cod)";
    $stmt = $db->prepare($sql);
    $ok = $stmt->execute([
        ':n'   => $nombre,
        ':a'   => $apellidos,
        ':c'   => $correo,
        ':p'   => $contrasena,
        ':t'   => $tratamiento,
        ':cod' => $codigo
    ]);

    if ($ok) {
        return ['status'=>'success','msg'=>'¡Usuario registrado con éxito!'];
    } else {
        return ['status'=>'error','msg'=>'Error al registrar el usuario.'];
    }
}