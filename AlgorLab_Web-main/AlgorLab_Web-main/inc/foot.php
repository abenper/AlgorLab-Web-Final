<footer class="text-center py-4 bg-dark text-white mt-auto">
  <p class="mb-0">© <?= date('Y') ?> AlgorLab. Todos los derechos reservados.</p>

  <?php
  date_default_timezone_set('Europe/Madrid');
  $fecha_es = date('l, d-m-Y H:i:s');

  // Explode del día actual
  $hoy_completo = date('l, d-m-Y');
  $partes = explode(", ", $hoy_completo);


  $fecha_simple = explode("-", $partes[1]);
  $dia = $fecha_simple[0];
  $mes = $fecha_simple[1];
  $anio = $fecha_simple[2];

  // USA
  date_default_timezone_set('America/New_York');
  $fecha_usa = date('l, m-d-Y h:i:s A');
  ?>

  <p class="mb-0">
    <strong>España:</strong> <?= $fecha_es ?><br>
    <strong>EE.UU. (NY):</strong> <?= $fecha_usa ?>
  </p>

  <p class="mb-0 small">
    Día de la semana: <strong><?= $partes[0] ?></strong><br>
    Día: <strong><?= $dia ?></strong>, Mes: <strong><?= $mes ?></strong>, Año: <strong><?= $anio ?></strong>
  </p>
</footer>