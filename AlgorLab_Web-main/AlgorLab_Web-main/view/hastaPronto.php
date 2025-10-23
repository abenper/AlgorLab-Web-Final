<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

session_unset();
session_destroy();
?>

<div class="container py-5 text-center">
    <div class="card shadow-lg p-4">
        <h1 class="display-5 mb-3 text-success">¡Gracias por haber formado parte de AlgorLab!</h1>
        <p class="lead">Tu cuenta ha sido eliminada correctamente. Esperamos volver a verte pronto.</p>
        <hr class="my-4">
        <a href="index.php?vista=home" class="btn btn-primary btn-lg mt-3">Volver al inicio</a>
    </div>
</div>