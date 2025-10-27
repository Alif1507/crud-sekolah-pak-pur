<?php
require_once __DIR__ . '/../../config.php';
auth_require_login();
$title = 'Data Murid';

// Read all murid
$stmt = $pdo->query('SELECT * FROM murid ORDER BY id_murid DESC');
$murid = $stmt->fetchAll();

ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Data Murid</h3>
  <a href="/murid/create.php" class="btn btn-success">+ Tambah</a>
</div>

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>ID</th><th>Nama</th><th>NIS</th><th>Jurusan</th><th>Kelas</th><th>Alamat</th><th width="150">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($murid as $m): ?>
    <tr>
      <td><?= htmlspecialchars($m['id_murid']) ?></td>
      <td><?= htmlspecialchars($m['nama']) ?></td>
      <td><?= htmlspecialchars($m['nis']) ?></td>
      <td><?= htmlspecialchars($m['jurusan']) ?></td>
      <td><?= htmlspecialchars($m['kelas']) ?></td>
      <td><?= htmlspecialchars($m['alamat']) ?></td>
      <td>
        <a class="btn btn-sm btn-primary" href="/murid/edit.php?id=<?= $m['id_murid'] ?>">Edit</a>
        <a class="btn btn-sm btn-danger" href="/murid/delete.php?id=<?= $m['id_murid'] ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<p class="text-muted small">Catatan: Menghapus murid akan otomatis menghapus nilai terkait karena ON DELETE CASCADE pada FK tabel nilai. fileciteturn0file0</p>

<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php';
