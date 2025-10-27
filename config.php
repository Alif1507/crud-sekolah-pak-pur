<?php
$host = getenv('DB_HOST') ?: 'db';    
$db   = getenv('DB_NAME') ?: 'sekolah';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: 'mawkeren';
$port = getenv('DB_PORT') ?: '3306';    

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
$pdo = new PDO($dsn, $user, $pass, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);



if (session_status() === PHP_SESSION_NONE) {
session_start();
}



require_once __DIR__ . '/auth.php';