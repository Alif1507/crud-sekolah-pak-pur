<?php
require_once __DIR__ . '/../config.php';
auth_require_login();

$title = 'Dashboard';
ob_start(); ?>
<div class="row g-3">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Kelola Murid</h5>
        <p class="card-text">Tambah, lihat, ubah, hapus data murid.</p>
        <a href="/murid/index.php" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Kelola Nilai</h5>
        <p class="card-text">Input nilai, edit, hapus & lihat rekap (join murid).</p>
        <a href="/nilai/index.php" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/layout.php';