<?php
/* ============================================================
   ARCO — مثبّت قاعدة البيانات
   افتح هذا الملف مرة واحدة من المتصفح ثم احذفه من السيرفر.
   ============================================================ */
require_once __DIR__ . '/includes/config.php';

$log = [];
$ok  = true;

try {
    /* 1) الاتصال بالسيرفر وإنشاء قاعدة البيانات إن لم تكن موجودة
          (على cPanel أنشئ القاعدة من MySQL Databases ثم شغّل هذا الملف) */
    $pdo = new PDO('mysql:host=' . DB_HOST, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    $log[] = 'قاعدة البيانات جاهزة: ' . DB_NAME;

    $pdo->exec('USE `' . DB_NAME . '`');

    /* 2) جدول المواعيد */
    $pdo->exec("CREATE TABLE IF NOT EXISTS appointments (
        id            INT AUTO_INCREMENT PRIMARY KEY,
        ref_no        VARCHAR(32)  NOT NULL UNIQUE,
        name          VARCHAR(150) NOT NULL,
        phone         VARCHAR(40)  NOT NULL,
        email         VARCHAR(150) DEFAULT NULL,
        service       VARCHAR(150) DEFAULT NULL,
        project_type  VARCHAR(100) DEFAULT NULL,
        location      VARCHAR(200) DEFAULT NULL,
        pref_date     DATE         DEFAULT NULL,
        pref_time     VARCHAR(10)  DEFAULT NULL,
        meet_mode     VARCHAR(80)  DEFAULT NULL,
        notes         TEXT,
        admin_note    TEXT,
        lang          VARCHAR(5)   DEFAULT 'ar',
        ip            VARCHAR(45)  DEFAULT NULL,
        status        ENUM('new','confirmed','done','cancelled') NOT NULL DEFAULT 'new',
        created_at    DATETIME     NOT NULL,
        INDEX idx_status (status),
        INDEX idx_date (pref_date)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    $log[] = 'جدول المواعيد (appointments) جاهز';

    /* 3) جدول رسائل التواصل */
    $pdo->exec("CREATE TABLE IF NOT EXISTS messages (
        id         INT AUTO_INCREMENT PRIMARY KEY,
        name       VARCHAR(150) NOT NULL,
        phone      VARCHAR(40)  NOT NULL,
        email      VARCHAR(150) DEFAULT NULL,
        subject    VARCHAR(200) DEFAULT NULL,
        body       TEXT         NOT NULL,
        lang       VARCHAR(5)   DEFAULT 'ar',
        ip         VARCHAR(45)  DEFAULT NULL,
        status     ENUM('new','read') NOT NULL DEFAULT 'new',
        created_at DATETIME     NOT NULL,
        INDEX idx_status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    $log[] = 'جدول الرسائل (messages) جاهز';

} catch (Throwable $e) {
    $ok = false;
    $log[] = 'خطأ: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>تثبيت موقع أركو</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;800;900&display=swap" rel="stylesheet">
<style>
body{font-family:'Cairo',sans-serif;background:#F6F8FB;margin:0;padding:50px 20px;color:#4A5265}
.box{max-width:680px;margin:auto;background:#fff;border:1px solid #E2E6ED;border-radius:20px;padding:40px;box-shadow:0 12px 36px rgba(38,43,60,.08)}
h1{color:#3C4257;font-size:1.6rem;margin:0 0 8px}
.sub{color:#7A8296;margin-bottom:26px}
li{padding:11px 0;border-bottom:1px solid #EEF1F6;list-style:none}
li::before{content:"✓";color:#1B9DD9;font-weight:900;margin-left:10px}
.err li::before{content:"✕";color:#C03A28}
.btn{display:inline-block;margin-top:26px;background:#1B9DD9;color:#fff;padding:14px 30px;border-radius:99px;text-decoration:none;font-weight:800}
.warn{background:#FFF7E6;border:1px solid #FFE0A3;color:#8A6100;padding:16px 18px;border-radius:12px;margin-top:24px;font-weight:700;font-size:.93rem}
ul{padding:0;margin:0}
</style>
</head>
<body>
<div class="box">
  <h1><?= $ok ? 'تم التثبيت بنجاح' : 'فشل التثبيت' ?></h1>
  <p class="sub">موقع أركو للمقاولات العمومية والتسويق العقاري</p>
  <ul class="<?= $ok ? '' : 'err' ?>">
    <?php foreach ($log as $l): ?><li><?= htmlspecialchars($l, ENT_QUOTES, 'UTF-8') ?></li><?php endforeach; ?>
  </ul>
  <?php if ($ok): ?>
  <div class="warn">
    مهم: احذف ملف <b>install.php</b> من السيرفر الآن، وغيّر بيانات الدخول في
    <b>includes/config.php</b> (ADMIN_USER / ADMIN_PASS) وبيانات التواصل.
  </div>
  <a class="btn" href="index.php">فتح الموقع</a>
  <a class="btn" href="admin/" style="background:#3C4257">لوحة التحكم</a>
  <?php endif; ?>
</div>
</body>
</html>
