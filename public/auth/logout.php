<?php
require_once __DIR__ . '/../../config.php';
if (auth_current_user()) { auth_logout(); }
header('Location: /auth/login.php');
exit;