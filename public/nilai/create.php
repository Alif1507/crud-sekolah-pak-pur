<?php
require_once __DIR__ . '/../../config.php';
$title = 'Tambah Nilai';

// Ambil daftar murid untuk dropdown
$murid = $pdo->query('SELECT id_murid, nama, nis FROM murid ORDER BY nama')->fetchAll();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_murid = (int)($_POST['id_murid'] ?? 0);
  $agama = (float)($_POST['agama'] ?? 0);
  $mtk = (float)($_POST['mtk'] ?? 0);
  $indo = (float)($_POST['indo'] ?? 0);
  $ing = (float)($_POST['ing'] ?? 0);
  $kejuruan = (float)($_POST['kejuruan'] ?? 0);

  if (!$id_murid) $errors['id_murid'] = 'Pilih murid';

  if (!$errors) {
    $stmt = $pdo->prepare('INSERT INTO nilai (id_murid, agama, mtk, indo, ing, kejuruan) VALUES (?,?,?,?,?,?)');
    $stmt->execute([$id_murid, $agama, $mtk, $indo, $ing, $kejuruan]);
    header('Location: /nilai/index.php');
    exit;
  }
}

ob_start(); ?>
<h3>Tambah Nilai</h3>
<form method="post" class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Murid</label>
    <select name="id_murid" class="form-select">
      <option value="">-- pilih --</option>
      <?php foreach ($murid as $m): ?>
        <option value="<?= $m['id_murid'] ?>" <?= ((int)($_POST['id_murid'] ?? 0) === (int)$m['id_murid']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($m['nama']) ?> (<?= htmlspecialchars($m['nis']) ?>)
        </option>
      <?php endforeach; ?>
    </select>
    <div class="text-danger small"><?= $errors['id_murid'] ?? '' ?></div>
  </div>

  <?php foreach ([['agama','Agama'],['mtk','MTK'],['indo','B. Indonesia'],['ing','B. Inggris'],['kejuruan','Kejuruan']] as [$name,$label]): ?>
    <div class="col-md-3">
      <label class="form-label"><?= $label ?></label>
      <input type="number" step="0.01" min="0" max="100" name="<?= $name ?>" class="form-control" value="<?= htmlspecialchars($_POST[$name] ?? '') ?>">
    </div>
  <?php endforeach; ?>

  <div class="col-12">
    <button class="btn btn-primary">Simpan</button>
    <a href="/nilai/index.php" class="btn btn-secondary">Batal</a>
  </div>
</form>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php';