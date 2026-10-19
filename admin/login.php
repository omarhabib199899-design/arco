<?php
require_once __DIR__ . '/auth.php';

if (admin_logged()) { header('Location: index.php'); exit; }

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim((string)($_POST['user'] ?? ''));
    $p = (string)($_POST['pass'] ?? '');
    if (!a_csrf_ok()) {
        $err = 'انتهت صلاحية الجلسة، حاول مرة أخرى.';
    } elseif (hash_equals(ADMIN_USER, $u) && hash_equals(ADMIN_PASS, $p)) {
        session_regenerate_id(true);
        $_SESSION['arco_admin'] = $u;
        header('Location: index.php'); exit;
    } else {
        $err = 'بيانات الدخول غير صحيحة.';
        usleep(400000);
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>دخول لوحة التحكم | ARCO</title>
<link rel="icon" href="../assets/img/logo.jpg">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-wrap">
  <form class="login-card" method="post">
    <?= a_csrf_field() ?>
    <img src="../assets/img/logo.jpg" alt="ARCO">
    <h1>لوحة تحكم أركو</h1>
    <p>إدارة المواعيد ورسائل العملاء</p>

    <?php if ($err): ?><div class="alert a-err"><?= a_e($err) ?></div><?php endif; ?>

    <div class="fld">
      <label for="user">اسم المستخدم</label>
      <input class="inp" type="text" id="user" name="user" required autofocus>
    </div>
    <div class="fld">
      <label for="pass">كلمة المرور</label>
      <input class="inp" type="password" id="pass" name="pass" required>
    </div>
    <button class="btn btn-p btn-block" type="submit">دخول</button>
    <p style="margin-top:20px"><a href="../index.php" style="color:var(--muted);font-size:.85rem">&rarr; العودة للموقع</a></p>
  </form>
</div>
</body>
</html>
