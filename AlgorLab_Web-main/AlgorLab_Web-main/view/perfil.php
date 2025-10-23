<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once './php/main.php';

// Redirigir si no está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php?vista=login");
    exit;
}

$db     = conexion();
$userId = $_SESSION['usuario_id'];

// Obtener mensajes (solo para actualizar)
$jsStatus = $_SESSION['perfil_status'] ?? '';
$jsMsg    = $_SESSION['perfil_msg']    ?? '';
unset($_SESSION['perfil_status'], $_SESSION['perfil_msg']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['actualizar'])) {
        require_once './php/usuarioActualizar.php';
        $resultado = actualizarUsuario($_POST, $userId);

        $_SESSION['perfil_status'] = $resultado['status'];
        $_SESSION['perfil_msg']    = $resultado['msg'];

        if (!empty($resultado['nuevoCorreo'])) {
            $_SESSION['usuario_email'] = $resultado['nuevoCorreo'];
        }
        header("Location: index.php?vista=perfil");
        exit;

    } elseif (isset($_POST['eliminar'])) {
        require_once './php/usuarioEliminar.php';
        $resultado = eliminarUsuario($userId);

        if ($resultado['status'] === 'success') {
            // Destruir sesión y redirigir inmediatamente a logout
            session_destroy();
            header("Location: index.php?vista=hastaPronto");
            exit;
        } else {
            // En caso de error al eliminar, mostrar mensaje
            $_SESSION['perfil_status'] = $resultado['status'];
            $_SESSION['perfil_msg']    = $resultado['msg'];
            header("Location: index.php?vista=perfil");
            exit;
        }
    }
}

// Recarga los datos del usuario
$stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$userId]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container py-5">
  <h2 class="mb-4">Tu perfil</h2>

  <?php if ($jsStatus): ?>
    <div class="alert alert-<?= $jsStatus === 'success' ? 'success' : 'danger' ?> mb-4">
      <?= htmlspecialchars($jsMsg) ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="" autocomplete="off">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" name="nombre" id="nombre" class="form-control"
             value="<?= htmlspecialchars($userData['nombre']) ?>" required>
    </div>
    <div class="mb-3">
      <label for="apellidos" class="form-label">Apellidos</label>
      <input type="text" name="apellidos" id="apellidos" class="form-control"
             value="<?= htmlspecialchars($userData['apellidos']) ?>" required>
    </div>
    <div class="mb-3">
      <label for="correo" class="form-label">Correo electrónico</label>
      <input type="email" name="correo" id="correo" class="form-control"
             value="<?= htmlspecialchars($userData['correo']) ?>" required>
    </div>
    <div class="mb-3">
      <label for="tratamiento" class="form-label">Tratamiento</label>
      <select name="tratamiento" id="tratamiento" class="form-select" required>
        <?php $opts = ['Masculino', 'Femenino', 'Otro']; foreach ($opts as $o): ?>
          <option value="<?= $o ?>" <?= $userData['tratamiento'] === $o ? 'selected' : '' ?>>
            <?= $o ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label for="passActual" class="form-label">Contraseña actual</label>
      <input type="password" name="passActual" id="passActual" class="form-control" placeholder="********" required>
    </div>

    <hr>
    <p>Cambiar contraseña (opcional):</p>
    <div class="mb-3">
      <label for="nuevaPass1" class="form-label">Nueva contraseña</label>
      <input type="password" name="nuevaPass1" id="nuevaPass1" class="form-control" placeholder="********">
    </div>
    <div class="mb-3">
      <label for="nuevaPass2" class="form-label">Repetir nueva contraseña</label>
      <input type="password" name="nuevaPass2" id="nuevaPass2" class="form-control" placeholder="********">
    </div>

    <div class="d-flex gap-3">
      <button type="submit" name="actualizar" class="btn btn-primary">Actualizar perfil</button>
      <button type="submit" name="eliminar" class="btn btn-danger"
              onclick="return confirm('¿Seguro que quieres eliminar tu cuenta? Esta acción no se puede deshacer?')">
        Eliminar cuenta
      </button>
    </div>
  </form>
</div>