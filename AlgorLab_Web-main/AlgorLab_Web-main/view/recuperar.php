<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once "./php/main.php";
require "./php/verificarCodigo.php";

$jsStatus   = '';
$jsMsg      = '';
$jsRedirect = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = procesarRecuperar();

    $jsStatus   = $resultado['status'] ?? 'error';
    $jsMsg      = $resultado['msg']    ?? 'Error inesperado';
    if (!empty($resultado['redirect']) && $resultado['redirect'] === true) {
        $jsRedirect = 'index.php?vista=login';
    }
}
?>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
  <div class="card shadow p-4 form-with-message" style="width: 100%; max-width: 400px; border-radius: 12px;">
    <div class="text-center mb-4">
      <i class="bi bi-key-fill" style="font-size: 64px; color: #000;"></i>
    </div>

    <form action="" method="POST" autocomplete="off" novalidate>
      <div class="mb-3">
        <label for="correo" class="form-label fw-semibold">Correo electrónico</label>
        <input
          type="email"
          class="form-control form-control-lg"
          id="correo"
          name="correo"
          maxlength="100"
          required
          placeholder="Tu correo registrado"
          value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>">
      </div>

      <div class="mb-3">
        <label for="codigo" class="form-label fw-semibold">Código de recuperación</label>
        <input
          type="text"
          class="form-control form-control-lg"
          id="codigo"
          name="codigo"
          maxlength="10"
          required
          placeholder="Ej: 123456"
          value="<?= htmlspecialchars($_POST['codigo'] ?? '') ?>">
      </div>

      <hr>

      <div class="mb-3">
        <label for="nuevaPass1" class="form-label fw-semibold">Nueva contraseña</label>
        <input
          type="password"
          class="form-control form-control-lg"
          id="nuevaPass1"
          name="nuevaPass1"
          maxlength="100"
          required
          placeholder="Introduce tu nueva contraseña">
      </div>

      <div class="mb-3">
        <label for="nuevaPass2" class="form-label fw-semibold">Repetir nueva contraseña</label>
        <input
          type="password"
          class="form-control form-control-lg"
          id="nuevaPass2"
          name="nuevaPass2"
          maxlength="100"
          required
          placeholder="Repite la contraseña">
      </div>

      <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-dark btn-lg rounded-pill">Restablecer contraseña</button>
      </div>

      <div class="text-center">
        <a href="index.php?vista=login" class="text-decoration-none">Volver al login</a>
      </div>
    </form>
  </div>
</div>