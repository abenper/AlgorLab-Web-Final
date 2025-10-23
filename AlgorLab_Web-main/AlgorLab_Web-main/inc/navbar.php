<?php
  include_once 'session_start.php'; // Asegura que se inicia la sesión
?>

<nav class="navbar navbar-expand-lg navbar-dark custom-navbar px-4 py-3">
  <!-- Logo -->
  <a class="navbar-brand d-flex align-items-center" href="index.php?vista=home">
    <img src="img/AlgorLab.png" alt="AlgorLab" height="60" class="me-3">
    <span class="fw-bold fs-4 text-light">AlgorLab</span>
  </a>

  <!-- Botón hamburguesa responsive -->
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Contenido del navbar -->
  <div class="collapse navbar-collapse" id="navMenu">
    <ul class="navbar-nav ms-auto align-items-center gap-4">

      <!-- Dropdown con hamburguesa -->
      <li class="nav-item dropdown">
        <a class="nav-link d-flex flex-column align-items-center text-center no-caret" href="#" id="navDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-list fs-2"></i>
          <small>Cursos</small>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navDropdown">
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2" href="index.php?vista=cursos">
              <i class="bi bi-grid-3x3-gap"></i> Nuestros Cursos
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2" href="index.php?vista=curso_detalle&curso=java">
              <i class="bi bi-cpu"></i> Curso JAVA
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2" href="index.php?vista=curso_detalle&curso=csharp">
              <i class="bi bi-code-slash"></i> Curso CSHARP
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2" href="index.php?vista=curso_detalle&curso=php">
              <i class="bi bi-terminal"></i> Curso PHP
            </a>
          </li>
        </ul>
      </li>

      <?php if (isset($_SESSION['usuario_id'])): ?>
        <!-- Aula Virtual -->
        <li class="nav-item">
          <a class="nav-link d-flex flex-column align-items-center text-center" href="index.php?vista=aula_virtual">
            <i class="bi bi-laptop fs-2"></i>
            <small>Aula Virtual</small>
          </a>
        </li>

        <!-- Cuenta con dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link d-flex flex-column align-items-center text-center no-caret" href="#" id="cuentaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle fs-2"></i>
            <small>Cuenta</small>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cuentaDropdown">
            <li>
              <a class="dropdown-item d-flex align-items-center gap-2" href="index.php?vista=perfil">
                <i class="bi bi-gear"></i> Configurar cuenta
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center gap-2" href="index.php?vista=logout">
                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
              </a>
            </li>
          </ul>
        </li>
      <?php else: ?>
        <!-- Iniciar sesión -->
        <li class="nav-item">
          <a class="nav-link d-flex flex-column align-items-center text-center" href="index.php?vista=login">
            <i class="bi bi-person-circle fs-2"></i>
            <small>Iniciar sesión</small>
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>