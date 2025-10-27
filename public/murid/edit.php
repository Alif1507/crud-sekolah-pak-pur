<?php
require_once __DIR__ . '/../../config.php';
auth_require_login();
$title = 'Edit Murid';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM murid WHERE id_murid=?');
$stmt->execute([$id]);
$data = $stmt->fetch();
if (!$data) { http_response_code(404); die('Murid tidak ditemukan'); }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = trim($_POST['nama'] ?? '');
  $nis = trim($_POST['nis'] ?? '');
  $jurusan = trim($_POST['jurusan'] ?? '');
  $kelas = trim($_POST['kelas'] ?? '');
  $alamat = trim($_POST['alamat'] ?? '');

  if ($nama === '') $errors['nama'] = 'Nama wajib diisi';
  if ($nis === '') $errors['nis'] = 'NIS wajib diisi';

  if (!$errors) {
    $stmt = $pdo->prepare('UPDATE murid SET nama=?, nis=?, jurusan=?, kelas=?, alamat=? WHERE id_murid=?');
    $stmt->execute([$nama, $nis, $jurusan, $kelas, $alamat, $id]);
    header('Location: /murid/index.php');
    exit;
  }
}

ob_start(); ?>
<h3>Edit Murid</h3>
<form method="post" class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Nama</label>
    <input name="nama" class="form-control" value="<?= htmlspecialchars($_POST['nama'] ?? $data['nama']) ?>">
    <div class="text-danger small"><?= $errors['nama'] ?? '' ?></div>
  </div>
  <div class="col-md-6">
    <label class="form-label">NIS</label>
    <input name="nis" class="form-control" value="<?= htmlspecialchars($_POST['nis'] ?? $data['nis']) ?>">
    <div class="text-danger small"><?= $errors['nis'] ?? '' ?></div>
  </div>
  <div class="col-md-4">
    <label class="form-label">Jurusan</label>
    <input name="jurusan" class="form-control" value="<?= htmlspecialchars($_POST['jurusan'] ?? $data['jurusan']) ?>">
  </div>
  <div class="col-md-4">
    <label class="form-label">Kelas</label>
    <input name="kelas" class="form-control" value="<?= htmlspecialchars($_POST['kelas'] ?? $data['kelas']) ?>">
  </div>
  <div class="col-md-12">
    <label class="form-label">Alamat</label>
    <textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($_POST['alamat'] ?? $data['alamat']) ?></textarea>
  </div>
  <div class="col-12">
    <button class="btn btn-primary">Update</button>
    <a href="/murid/index.php" class="btn btn-secondary">Batal</a>
  </div>
</form>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php';
