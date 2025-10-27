<?php
require_once __DIR__ . '/../../config.php';
auth_require_login();
$id = (int)($_GET['id'] ?? 0);
if ($id) {
  $stmt = $pdo->prepare('DELETE FROM nilai WHERE id_nilai=?');
  $stmt->execute([$id]);
}
header('Location: /nilai/index.php');
