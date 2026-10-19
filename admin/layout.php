<?php
/* يُستدعى بعد require_admin() — يحتاج $A_TITLE و $A_SUB و $A_PAGE */
$A_TITLE = $A_TITLE ?? 'لوحة التحكم';
$A_SUB   = $A_SUB   ?? '';
$A_PAGE  = $A_PAGE  ?? '';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= a_e($A_TITLE) ?> | ARCO Admin</title>
<link rel="icon" href="../assets/img/logo.jpg">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="admin">

  <aside class="side">
    <div class="brand">
      <img src="../assets/img/logo.jpg" alt="ARCO">
      <span><strong>ARCO</strong><span>لوحة التحكم</span></span>
    </div>
    <nav>
      <a href="index.php" class="<?= $A_PAGE === 'home' ? 'on' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l9-7 9 7v9a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/></svg>
        المواعيد
      </a>
      <a href="messages.php" class="<?= $A_PAGE === 'msg' ? 'on' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z"/><path d="m4 6 8 6 8-6"/></svg>
        الرسائل
      </a>
      <a href="../index.php" target="_blank">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18"/></svg>
        عرض الموقع
      </a>
      <div class="out">
        <a href="logout.php">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
          تسجيل الخروج
        </a>
      </div>
    </nav>
  </aside>

  <main class="main">
    <div class="topline">
      <div>
        <h1><?= a_e($A_TITLE) ?></h1>
        <?php if ($A_SUB): ?><p><?= a_e($A_SUB) ?></p><?php endif; ?>
      </div>
      <span class="muted">مرحبًا، <?= a_e($_SESSION['arco_admin']) ?></span>
    </div>
