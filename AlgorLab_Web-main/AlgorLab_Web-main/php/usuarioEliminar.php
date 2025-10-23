<?php
include_once 'main.php'; // para la función conexion()

function eliminarUsuario($userId) {
    $db = conexion();

    // Verificar existencia
    $stmt = $db->prepare("SELECT id FROM usuarios WHERE id = ?");
    $stmt->execute([$userId]);
    $userData = $stmt->fetch();

    if (!$userData) {
        return ['status' => 'error', 'msg' => 'Usuario no encontrado.'];
    }

    // Eliminar registro
    $stmt = $db->prepare("DELETE FROM usuarios WHERE id = ?");
    if ($stmt->execute([$userId])) {
        return ['status' => 'success', 'msg' => 'Cuenta eliminada correctamente.'];
    } else {
        return ['status' => 'error', 'msg' => 'No se pudo eliminar la cuenta.'];
    }
}