<?php
include_once './inc/session_start.php';
include_once './php/obtenerCurso.php';
include_once './php/subirEntrega.php';

if (!isset($_SESSION['usuario_id'])) {
  header('Location: index.php?vista=login');
  exit;
}

// Ejecutamos subirTarea() solo si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo']) && isset($_POST['tarea_id'])) {
  subirTarea();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<div class='alert alert-danger'>ID de curso no válido.</div>";
  exit;
}

$curso_id = intval($_GET['id']);
$curso = obtenerCurso($curso_id);
$tareas = obtenerTareasPorCurso($curso_id);

if (!$curso) {
  echo "<div class='alert alert-warning'>Curso no encontrado.</div>";
  exit;
}
?>

<main class="flex-grow-1">
  <div class="container mt-5">
    <h2 class="mb-4"><?= htmlspecialchars($curso['nombre']) ?></h2>

    <?php if (count($tareas) > 0): ?>
      <div class="list-group">
        <?php foreach ($tareas as $tarea): ?>
          <div class="list-group-item mb-3">
            <h5 class="mb-1"><?= htmlspecialchars($tarea['titulo']) ?></h5>
            <p class="mb-1"><?= htmlspecialchars($tarea['descripcion']) ?></p>
            <small class="text-muted">Fecha de entrega: <?= htmlspecialchars($tarea['fecha_entrega']) ?></small>
            <?php if ($tarea['estado_entrega']): ?>
              <div class="alert alert-info mt-2 mb-2 p-2">
                Estado: <strong><?= htmlspecialchars($tarea['estado_entrega']) ?></strong><br>
                <a href="<?= htmlspecialchars($tarea['url_archivo']) ?>" target="_blank">Ver archivo entregado</a><br>

                <?php if (!empty($tarea['observacion_profesor'])): ?>
                  <hr class="my-2">
                  <strong>Observación del profesor:</strong><br>
                  <span><?= nl2br(htmlspecialchars($tarea['observacion_profesor'])) ?></span>
                <?php endif; ?>
              </div>
            <?php else: ?>
              <form action="" method="POST" enctype="multipart/form-data" class="mt-3">
                <input type="hidden" name="tarea_id" value="<?= $tarea['id'] ?>">
                <div class="mb-2">
                  <input type="file" name="archivo" accept="application/pdf" required class="form-control">
                </div>
                <button type="submit" class="btn btn-success btn-sm">Subir entrega</button>
              </form>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-muted">No hay tareas para este curso.</p>
    <?php endif; ?>
  </div>
</main>
