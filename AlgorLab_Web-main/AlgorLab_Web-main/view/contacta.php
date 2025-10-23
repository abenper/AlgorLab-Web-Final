<div class="container d-flex justify-content-center align-items-center mb-5" style="min-height: 90vh;">
  <div class="card shadow p-5" style="width: 100%; max-width: 600px; border-radius: 1rem;">
    <h2 class="text-center mb-4 fw-bold text-primary">Contáctanos</h2>
    <p class="text-center mb-4 text-muted">¿Tienes alguna duda o quieres más información? Escríbenos y te responderemos pronto.</p>

    <form action="" method="POST" autocomplete="off" novalidate>
      <div class="mb-3">
        <label for="nombre" class="form-label fw-semibold">Nombre completo</label>
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu nombre completo" required minlength="3" maxlength="50" pattern="[a-zA-ZÀ-ÿ\s]+" title="Solo letras y espacios">
      </div>

      <div class="mb-3">
        <label for="email" class="form-label fw-semibold">Correo electrónico</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="nombre@ejemplo.com" required maxlength="100">
      </div>

      <div class="mb-3">
        <label for="telefono" class="form-label fw-semibold">Teléfono (opcional)</label>
        <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ejemplo: +34 600 123 456" pattern="^\+?[0-9\s\-]{7,15}$" maxlength="20" title="Solo números, espacios, guiones y +">
      </div>

      <div class="mb-3">
        <label for="mensaje" class="form-label fw-semibold">Mensaje</label>
        <textarea class="form-control" id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí..." required minlength="10" maxlength="500"></textarea>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-lg rounded-pill">Enviar mensaje</button>
      </div>
    </form>
  </div>
</div>