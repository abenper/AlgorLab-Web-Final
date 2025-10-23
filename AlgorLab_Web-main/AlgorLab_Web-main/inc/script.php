<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (!empty($jsStatus)): ?>
<script>
  Swal.fire({
    icon: <?= json_encode($jsStatus) ?>,
    title: <?= json_encode($jsStatus === "success" ? "¡Éxito!" : "Ups…") ?>,
    text: <?= json_encode($jsMsg) ?>,
    position: 'center',
    timer: 3000,
    timerProgressBar: true,
    showConfirmButton: false,
    showCloseButton: <?= $jsStatus === "error" ? "true" : "false" ?>,
    allowOutsideClick: <?= $jsStatus === "error" ? "true" : "false" ?>,
    allowEscapeKey: <?= $jsStatus === "error" ? "true" : "false" ?>
  }).then(() => {
    <?php if (!empty($jsRedirect)): ?>
      window.location.href = <?= json_encode($jsRedirect) ?>;
    <?php endif; ?>
  });
</script>
<?php endif; ?>
</body>
</html>