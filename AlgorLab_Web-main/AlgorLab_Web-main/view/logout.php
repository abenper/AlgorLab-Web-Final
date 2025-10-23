<?php
	session_destroy();
	header("Refresh: 3; URL=index.php?vista=home");
?>
<div class="d-flex flex-column justify-content-center align-items-center vh-100 bg-light">
  <div class="card shadow-sm p-4 text-center" style="max-width: 400px;">
    <i class="bi bi-heart-fill display-1 text-danger mb-3"></i>
    <h2 class="fw-bold mb-2">¡Hasta pronto!</h2>
    <p class="text-muted mb-4">
      Gracias por visitarnos. <br>
      Esperamos verte de nuevo muy pronto en <strong>AlgorLab</strong>.
    </p>
    <a href="index.php?vista=login" class="btn btn-primary px-4 mb-3">
      <i class="bi bi-arrow-left-circle me-2"></i>Volver al inicio
    </a>
    <p class="small text-secondary">Serás redirigido al inicio en unos segundos...</p>
  </div>
</div>