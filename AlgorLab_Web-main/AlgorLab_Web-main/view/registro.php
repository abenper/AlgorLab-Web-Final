<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once "./php/main.php";
require_once "./php/usuarioGuardar.php";

$jsStatus   = '';
$jsMsg      = '';
$jsRedirect = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = obtenerMensajeRegistro();

    $jsStatus   = $resultado['status'] ?? 'error';
    $jsMsg      = $resultado['msg']    ?? 'Error inesperado';

    if ($jsStatus === 'success') {
        $jsRedirect = 'index.php?vista=login';
    }
}
?>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
  <div class="card shadow p-4 form-with-message" style="width:100%;max-width:400px;border-radius:12px;">
    <div class="text-center mb-4">
      <i class="bi bi-person-plus-fill" style="font-size:64px;color:#000;"></i>
    </div>

    <h3 class="text-center fw-bold mb-3">Crear cuenta</h3>
    <p class="text-center text-muted mb-4">Completa el formulario para registrarte.</p>

    <form action="" method="POST" autocomplete="off" novalidate>
      <div class="mb-3">
        <label for="nombre" class="form-label fw-semibold">Nombre</label>
        <input
          type="text"
          id="nombre"
          name="usuarioNombre"
          class="form-control form-control-lg"
          maxlength="100"
          required
          placeholder="Tu nombre"
          value="<?= htmlspecialchars($_POST['usuarioNombre'] ?? '') ?>">
      </div>

      <div class="mb-3">
        <label for="apellidos" class="form-label fw-semibold">Apellidos</label>
        <input
          type="text"
          id="apellidos"
          name="usuarioApellidos"
          class="form-control form-control-lg"
          maxlength="150"
          required
          placeholder="Tus apellidos"
          value="<?= htmlspecialchars($_POST['usuarioApellidos'] ?? '') ?>">
      </div>

      <div class="mb-3">
        <label for="correo" class="form-label fw-semibold">Correo electrónico</label>
        <input
          type="email"
          id="correo"
          name="usuarioCorreo"
          class="form-control form-control-lg"
          maxlength="100"
          required
          placeholder="nombre@ejemplo.com"
          value="<?= htmlspecialchars($_POST['usuarioCorreo'] ?? '') ?>">
      </div>

      <div class="mb-3">
        <label for="tratamiento" class="form-label fw-semibold">Tratamiento</label>
        <select
          id="tratamiento"
          name="usuarioTratamiento"
          class="form-select form-select-lg"
          required>
          <?php
          $opts = ['Masculino','Femenino','Otro'];
          $sel = $_POST['usuarioTratamiento'] ?? 'Otro';
          foreach($opts as $o): ?>
            <option value="<?= $o?>" <?= $o=== $sel ? 'selected':'' ?>>
              <?= $o?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="pass1" class="form-label fw-semibold">Contraseña</label>
        <input
          type="password"
          id="pass1"
          name="usuarioPass1"
          class="form-control form-control-lg"
          maxlength="100"
          required
          placeholder="Crea una contraseña">
      </div>

      <div class="mb-4">
        <label for="pass2" class="form-label fw-semibold">Confirmar contraseña</label>
        <input
          type="password"
          id="pass2"
          name="usuarioPass2"
          class="form-control form-control-lg"
          maxlength="100"
          required
          placeholder="Repite la contraseña">
      </div>

      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-dark btn-lg rounded-pill">Registrarse</button>
      </div>
    </form>
  </div>
</div>