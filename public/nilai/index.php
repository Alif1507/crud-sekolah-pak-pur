<?php
require_once __DIR__ . '/../../config.php';
auth_require_login();
$title = 'Data Nilai';

// Join agar tampil nama murid
$sql = 'SELECT n.*, m.nama, m.nis, m.kelas FROM nilai n
        JOIN murid m ON m.id_murid = n.id_murid
        ORDER BY n.id_nilai DESC';
$rows = $pdo->query($sql)->fetchAll();

ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Data Nilai</h3>
  <a href="/nilai/create.php" class="btn btn-success">+ Tambah</a>
</div>

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>ID</th><th>Nama</th><th>NIS</th><th>Kelas</th>
      <th>Agama</th><th>MTK</th><th>Indo</th><th>Ing</th><th>Kejuruan</th>
      <th width="150">Aksi</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= $r['id_nilai'] ?></td>
      <td><?= htmlspecialchars($r['nama']) ?></td>
      <td><?= htmlspecialchars($r['nis']) ?></td>
      <td><?= htmlspecialchars($r['kelas']) ?></td>
      <td><?= $r['agama'] ?></td>
      <td><?= $r['mtk'] ?></td>
      <td><?= $r['indo'] ?></td>
      <td><?= $r['ing'] ?></td>
      <td><?= $r['kejuruan'] ?></td>
      <td>
        <a class="btn btn-sm btn-primary" href="/nilai/edit.php?id=<?= $r['id_nilai'] ?>">Edit</a>
        <a class="btn btn-sm btn-danger" href="/nilai/delete.php?id=<?= $r['id_nilai'] ?>" onclick="return confirm('Hapus nilai ini?')">Hapus</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<p class="text-muted small">Relasi id_murid pada tabel nilai terhubung ke murid(id_murid) dengan ON DELETE/UPDATE CASCADE. fileciteturn0file0</p>

<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php';