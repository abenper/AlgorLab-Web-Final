<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once "./php/main.php";
require "./php/iniciarSesion.php";

$jsStatus = '';
$jsMsg = '';
$jsRedirect = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = iniciarSesion();

    $jsStatus = $resultado['status'] ?? 'error';
    $jsMsg    = $resultado['msg'] ?? 'Error inesperado';

    if (!empty($resultado['redirect']) && $resultado['redirect'] === true) {
        $jsRedirect = 'index.php?vista=aula_virtual';
    }
}
?>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
  <div class="card shadow p-4 form-with-message" style="width: 100%; max-width: 400px; border-radius: 12px;">
    <div class="text-center mb-4">
      <i class="bi bi-person-circle" style="font-size: 64px; color: #000;"></i>
    </div>

      <?php if ($jsRedirect): ?>
        <script>
          setTimeout(() => {
            window.location.href = '<?= $jsRedirect ?>';
          }, 1500);
        </script>
      <?php endif; ?>

    <form action="" method="POST" autocomplete="off" novalidate>
      <div class="mb-3">
        <label for="correo" class="form-label fw-semibold">Correo electrónico</label>
        <input
          type="email"
          class="form-control form-control-lg"
          id="correo"
          name="loginCorreo"
          maxlength="100"
          required
          placeholder="Ingrese su correo electrónico"
          value="<?= isset($_POST['loginCorreo']) ? htmlspecialchars($_POST['loginCorreo']) : '' ?>">
      </div>

      <div class="mb-4">
        <label for="password" class="form-label fw-semibold">Contraseña</label>
        <input
          type="password"
          class="form-control form-control-lg"
          id="password"
          name="loginPass"
          maxlength="100"
          required
          placeholder="Ingrese su contraseña">
      </div>

      <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-dark btn-lg rounded-pill">Iniciar sesión</button>
      </div>

      <div class="text-center">
        <a href="index.php?vista=recuperar" class="text-decoration-none">¿Olvidaste tu contraseña?</a>
      </div>

      <div class="text-center mt-2">
        <span class="text-muted">¿No tienes cuenta?</span>
        <a href="index.php?vista=registro" class="fw-semibold text-decoration-none">Regístrate</a>
      </div>
    </form>
  </div>
</div>