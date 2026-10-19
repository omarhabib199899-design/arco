<?php
require_once __DIR__ . '/auth.php';
require_admin();

$msg = ''; $err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!a_csrf_ok()) {
        $err = 'انتهت صلاحية الجلسة.';
    } else {
        $id = (int)($_POST['id'] ?? 0);
        $action = $_POST['action'] ?? '';
        try {
            if ($action === 'read' && $id) {
                db()->prepare('UPDATE messages SET status="read" WHERE id=?')->execute([$id]);
                $msg = 'تم تعليم الرسالة كمقروءة.';
            } elseif ($action === 'delete' && $id) {
                db()->prepare('DELETE FROM messages WHERE id=?')->execute([$id]);
                $msg = 'تم حذف الرسالة.';
            }
        } catch (Throwable $e) { $err = 'حدث خطأ أثناء التنفيذ.'; }
    }
}

try {
    $rows = db()->query('SELECT * FROM messages ORDER BY (status="new") DESC, id DESC LIMIT 300')->fetchAll();
    $new  = (int)db()->query('SELECT COUNT(*) FROM messages WHERE status="new"')->fetchColumn();
    $all  = (int)db()->query('SELECT COUNT(*) FROM messages')->fetchColumn();
} catch (Throwable $e) {
    $rows = []; $new = 0; $all = 0;
    $err = 'تعذّر قراءة البيانات — شغّل install.php أولًا.';
}

$A_TITLE = 'الرسائل';
$A_SUB   = 'رسائل نموذج التواصل';
$A_PAGE  = 'msg';
require __DIR__ . '/layout.php';
?>

<?php if ($msg): ?><div class="alert a-ok"><?= a_e($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert a-err"><?= a_e($err) ?></div><?php endif; ?>

<div class="kpis" style="grid-template-columns:repeat(2,1fr);max-width:520px">
  <div class="kpi"><b><?= $all ?></b><span>إجمالي الرسائل</span></div>
  <div class="kpi k-new"><b><?= $new ?></b><span>غير مقروءة</span></div>
</div>

<div class="panel">
  <div class="panel-head"><h2>كل الرسائل</h2></div>
  <?php if (!$rows): ?>
    <div class="empty">لا توجد رسائل بعد.</div>
  <?php else: ?>
  <div class="tbl-scroll">
    <table>
      <thead>
        <tr><th>التاريخ</th><th>المُرسِل</th><th>الموضوع</th><th>الرسالة</th><th>الحالة</th><th>إجراءات</th></tr>
      </thead>
      <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td class="nowrap muted"><?= a_e(date('Y-m-d H:i', strtotime($r['created_at']))) ?></td>
          <td>
            <strong><?= a_e($r['name']) ?></strong>
            <div><a href="tel:<?= a_e($r['phone']) ?>" dir="ltr" style="color:var(--blue);font-weight:700"><?= a_e($r['phone']) ?></a></div>
            <?php if ($r['email']): ?><div class="muted" dir="ltr"><?= a_e($r['email']) ?></div><?php endif; ?>
          </td>
          <td><?= a_e($r['subject'] ?: '—') ?></td>
          <td style="max-width:420px"><?= nl2br(a_e($r['body'])) ?></td>
          <td class="nowrap"><span class="badge <?= $r['status'] === 'new' ? 'b-new' : 'b-done' ?>"><?= $r['status'] === 'new' ? 'جديدة' : 'مقروءة' ?></span></td>
          <td>
            <div class="row-actions">
              <?php if ($r['status'] === 'new'): ?>
              <form method="post">
                <?= a_csrf_field() ?>
                <input type="hidden" name="action" value="read">
                <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                <button class="btn btn-p btn-sm" type="submit">مقروءة</button>
              </form>
              <?php endif; ?>
              <a class="btn btn-g btn-sm" target="_blank" rel="noopener"
                 href="https://wa.me/<?= a_e(preg_replace('/\D+/', '', $r['phone'])) ?>">واتساب</a>
              <form method="post" onsubmit="return confirm('حذف الرسالة؟')">
                <?= a_csrf_field() ?>
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                <button class="btn btn-g btn-sm" type="submit" style="color:#C03A28;border-color:#F7C9C2">حذف</button>
              </form>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

</main></div></body></html>
