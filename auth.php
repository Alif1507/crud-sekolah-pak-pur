<?php

function auth_current_user() {
  return $_SESSION['user'] ?? null; 
}

function auth_require_login() {
  if (!auth_current_user()) {
    header('Location: /auth/login.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '/'));
    exit;
  }
}

function auth_login(PDO $pdo, string $username, string $password): bool {
  $stmt = $pdo->prepare('SELECT id, username, password, name FROM users WHERE username = ? LIMIT 1');
  $stmt->execute([$username]);
  $row = $stmt->fetch();
  if ($row && password_verify($password, $row['password'])) {
    if (session_status() === PHP_SESSION_ACTIVE) session_regenerate_id(true);
    $_SESSION['user'] = ['id' => $row['id'], 'username' => $row['username'], 'name' => $row['name']];
    return true;
  }
  return false;
}

function auth_logout() {
  $_SESSION = [];
  if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
  }
  session_destroy();
}