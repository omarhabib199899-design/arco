<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

function admin_logged() { return !empty($_SESSION['arco_admin']); }

function require_admin() {
    if (!admin_logged()) { header('Location: login.php'); exit; }
}

function a_e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function a_csrf() {
    if (empty($_SESSION['a_csrf'])) $_SESSION['a_csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['a_csrf'];
}
function a_csrf_field() { return '<input type="hidden" name="csrf" value="' . a_csrf() . '">'; }
function a_csrf_ok() {
    return isset($_POST['csrf'], $_SESSION['a_csrf']) && hash_equals($_SESSION['a_csrf'], $_POST['csrf']);
}

$STATUS_AR = [
    'new'       => 'جديد',
    'confirmed' => 'مؤكد',
    'done'      => 'تم',
    'cancelled' => 'ملغي',
];
