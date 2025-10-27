<?php
require_once __DIR__ . '/../../config.php';
$title = 'Login';

$error = '';
$next = $_GET['next'] ?? '/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = (string)($_POST['password'] ?? '');
  $next = $_POST['next'] ?? '/';
  if (auth_login($pdo, $username, $password)) {
    header('Location: ' . $next);
    exit;
  } else {
    $error = 'Username atau password salah';
  }
}


ob_start(); ?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="mb-3">Login</h3>
        <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="post">
          <input type="hidden" name="next" value="<?= htmlspecialchars($next) ?>">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input name="username" class="form-control" autofocus />
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" />
          </div>
          <div class="d-flex gap-2">
            <button class="btn btn-primary">Masuk</button>
            <a class="btn btn-secondary" href="/">Batal</a>
          </div>
          <p class="text-muted small mt-3 mb-0">User default: <code>admin</code> / <code>password</code></p>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php';