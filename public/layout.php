<?php 

?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $title ?? 'CRUD Sekolah' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Inter font for modern, clean look -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<?php $me = auth_current_user(); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="/index.php">CRUD Sekolah</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="nav" class="collapse navbar-collapse">
      <div class="navbar-nav ms-auto gap-1 align-items-lg-center">
        <a class="nav-link" href="/murid/index.php">Murid</a>
        <a class="nav-link" href="/nilai/index.php">Nilai</a>
        <?php if ($me): ?>
          <span class="navbar-text ms-2 me-2 small text-muted">Hi, <?= htmlspecialchars($me['name']) ?></span>
          <a class="btn btn-sm btn-secondary" href="/auth/logout.php">Logout</a>
        <?php else: ?>
          <a class="btn btn-sm btn-primary" href="/auth/login.php">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<main class="container py-4">
  <?= $content ?? '' ?>
</main>

<script>
// Smooth reveal-on-scroll with IntersectionObserver
(function() {
  const autoTargets = '.card, table, .btn, h1, h2, h3, h4, p, nav';
  document.querySelectorAll(autoTargets).forEach(el => el.classList.add('reveal'));
  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.08 });
  document.querySelectorAll('.reveal').forEach(el => io.observe(el));
})();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>