<?php
/*
./view/aula_virtual.php
*/
include_once './inc/session_start.php';
include_once './php/cargarCursos.php';

if (!isset($_SESSION['usuario_id'])) {
  header('Location: index.php?vista=login');
  exit;
}

$correo = $_SESSION['usuario_email'];
?>
<main class="flex-grow-1">
  <div class="container mt-5">
    <h2 class="mb-4">Tus cursos</h2>

    <?php if (count($cursos) > 0): ?>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($cursos as $curso): ?>
          <div class="col">
            <div class="card h-100 shadow-sm">
              <div class="card-body text-center">
                <h5 class="card-title"><?= htmlspecialchars($curso['nombre']) ?></h5>
                <a href="index.php?vista=asignatura&id=<?= $curso['id'] ?>" class="btn btn-primary mb-3">Entrar</a>

                <?php if (!empty($tareasPendientes[$curso['id']])): ?>
                  <p class="text-warning fw-semibold">Tienes tareas pendientes en este curso.</p>
                <?php else: ?>
                  <p class="text-muted">No tienes tareas pendientes.</p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="alert alert-warning">No estás inscrito en ningún curso.</div>
    <?php endif; ?>
  </div>
</main>