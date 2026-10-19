<?php
require_once __DIR__ . '/auth.php';
require_admin();

$msg = '';
$err = '';

/* ---- تحديث الحالة / الملاحظة / الحذف ---- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!a_csrf_ok()) {
        $err = 'انتهت صلاحية الجلسة.';
    } else {
        $id     = (int)($_POST['id'] ?? 0);
        $action = $_POST['action'] ?? '';
        try {
            if ($action === 'status' && $id) {
                $st = $_POST['status'] ?? 'new';
                if (in_array($st, ['new','confirmed','done','cancelled'], true)) {
                    db()->prepare('UPDATE appointments SET status=? WHERE id=?')->execute([$st, $id]);
                    $msg = 'تم تحديث حالة الموعد.';
                }
            } elseif ($action === 'note' && $id) {
                db()->prepare('UPDATE appointments SET admin_note=? WHERE id=?')
                    ->execute([trim((string)($_POST['admin_note'] ?? '')), $id]);
                $msg = 'تم حفظ الملاحظة.';
            } elseif ($action === 'delete' && $id) {
                db()->prepare('DELETE FROM appointments WHERE id=?')->execute([$id]);
                $msg = 'تم حذف الموعد.';
            }
        } catch (Throwable $e) {
            $err = 'حدث خطأ أثناء التنفيذ.';
        }
    }
}

/* ---- الفلترة ---- */
$filter = $_GET['s'] ?? 'all';
$valid  = ['all','new','confirmed','done','cancelled'];
if (!in_array($filter, $valid, true)) $filter = 'all';
$q = trim((string)($_GET['q'] ?? ''));

$sql    = 'SELECT * FROM appointments';
$where  = [];
$params = [];
if ($filter !== 'all') { $where[] = 'status = ?'; $params[] = $filter; }
if ($q !== '') {
    $where[] = '(name LIKE ? OR phone LIKE ? OR ref_no LIKE ? OR location LIKE ? OR service LIKE ?)';
    $like = '%' . $q . '%';
    array_push($params, $like, $like, $like, $like, $like);
}
if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
$sql .= ' ORDER BY (status="new") DESC, pref_date ASC, id DESC LIMIT 400';

try {
    $st = db()->prepare($sql);
    $st->execute($params);
    $rows = $st->fetchAll();

    $counts = ['all'=>0,'new'=>0,'confirmed'=>0,'done'=>0,'cancelled'=>0];
    foreach (db()->query('SELECT status, COUNT(*) c FROM appointments GROUP BY status') as $r) {
        $counts[$r['status']] = (int)$r['c'];
        $counts['all'] += (int)$r['c'];
    }
} catch (Throwable $e) {
    $rows = []; $counts = ['all'=>0,'new'=>0,'confirmed'=>0,'done'=>0,'cancelled'=>0];
    $err = 'تعذّر قراءة البيانات — شغّل install.php أولًا.';
}

$A_TITLE = 'المواعيد';
$A_SUB   = 'طلبات حجز المواعيد الواردة من الموقع';
$A_PAGE  = 'home';
require __DIR__ . '/layout.php';
?>

<?php if ($msg): ?><div class="alert a-ok"><?= a_e($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert a-err"><?= a_e($err) ?></div><?php endif; ?>

<div class="kpis">
  <div class="kpi"><b><?= $counts['all'] ?></b><span>إجمالي الطلبات</span></div>
  <div class="kpi k-new"><b><?= $counts['new'] ?></b><span>جديد</span></div>
  <div class="kpi k-ok"><b><?= $counts['confirmed'] + $counts['done'] ?></b><span>مؤكد / تم</span></div>
  <div class="kpi k-no"><b><?= $counts['cancelled'] ?></b><span>ملغي</span></div>
</div>

<div class="panel">
  <div class="panel-head">
    <div class="tabs">
      <?php foreach (['all'=>'الكل','new'=>'جديد','confirmed'=>'مؤكد','done'=>'تم','cancelled'=>'ملغي'] as $k => $lbl): ?>
      <a class="tab <?= $filter === $k ? 'on' : '' ?>" href="?s=<?= $k ?><?= $q !== '' ? '&q=' . urlencode($q) : '' ?>"><?= $lbl ?> (<?= $counts[$k] ?>)</a>
      <?php endforeach; ?>
    </div>
    <form method="get" style="display:flex;gap:8px">
      <input type="hidden" name="s" value="<?= a_e($filter) ?>">
      <input class="inp" style="width:220px;padding:9px 14px" type="text" name="q" value="<?= a_e($q) ?>" placeholder="بحث بالاسم / الهاتف / الرقم المرجعي">
      <button class="btn btn-g btn-sm" type="submit">بحث</button>
    </form>
  </div>

  <?php if (!$rows): ?>
    <div class="empty">لا توجد مواعيد مطابقة.</div>
  <?php else: ?>
  <div class="tbl-scroll">
    <table>
      <thead>
        <tr>
          <th>الرقم المرجعي</th>
          <th>العميل</th>
          <th>الخدمة</th>
          <th>الموعد</th>
          <th>التفاصيل</th>
          <th>الحالة</th>
          <th>إجراءات</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td class="nowrap">
            <strong dir="ltr"><?= a_e($r['ref_no']) ?></strong>
            <div class="muted"><?= a_e(date('Y-m-d H:i', strtotime($r['created_at']))) ?></div>
          </td>
          <td>
            <strong><?= a_e($r['name']) ?></strong>
            <div><a href="tel:<?= a_e($r['phone']) ?>" dir="ltr" style="color:var(--blue);font-weight:700"><?= a_e($r['phone']) ?></a></div>
            <?php if ($r['email']): ?><div class="muted" dir="ltr"><?= a_e($r['email']) ?></div><?php endif; ?>
            <div style="margin-top:5px">
              <a class="btn btn-g btn-sm" target="_blank" rel="noopener"
                 href="https://wa.me/<?= a_e(preg_replace('/\D+/', '', $r['phone'])) ?>">واتساب</a>
            </div>
          </td>
          <td>
            <?= a_e($r['service']) ?>
            <?php if ($r['project_type']): ?><div class="muted"><?= a_e($r['project_type']) ?></div><?php endif; ?>
          </td>
          <td class="nowrap">
            <strong><?= a_e($r['pref_date']) ?></strong>
            <div class="muted"><?= a_e($r['pref_time']) ?></div>
            <div class="muted"><?= a_e($r['meet_mode']) ?></div>
          </td>
          <td style="max-width:280px">
            <?php if ($r['location']): ?><div><?= a_e($r['location']) ?></div><?php endif; ?>
            <?php if ($r['notes']): ?><div class="muted"><?= nl2br(a_e($r['notes'])) ?></div><?php endif; ?>
            <form method="post" style="margin-top:8px;display:flex;gap:6px">
              <?= a_csrf_field() ?>
              <input type="hidden" name="action" value="note">
              <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
              <input class="inp" style="padding:7px 11px;font-size:.84rem" type="text" name="admin_note"
                     value="<?= a_e($r['admin_note']) ?>" placeholder="ملاحظة داخلية">
              <button class="btn btn-g btn-sm" type="submit">حفظ</button>
            </form>
          </td>
          <td class="nowrap"><span class="badge b-<?= a_e($r['status']) ?>"><?= a_e($STATUS_AR[$r['status']] ?? $r['status']) ?></span></td>
          <td>
            <form method="post" class="row-actions">
              <?= a_csrf_field() ?>
              <input type="hidden" name="action" value="status">
              <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
              <?php foreach (['confirmed'=>'تأكيد','done'=>'تم','cancelled'=>'إلغاء','new'=>'جديد'] as $k => $lbl):
                      if ($r['status'] === $k) continue; ?>
              <button class="btn btn-<?= $k === 'cancelled' ? 'g' : 'p' ?> btn-sm" type="submit" name="status" value="<?= $k ?>"><?= $lbl ?></button>
              <?php endforeach; ?>
            </form>
            <form method="post" onsubmit="return confirm('حذف هذا الموعد نهائيًا؟')" style="margin-top:6px">
              <?= a_csrf_field() ?>
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
              <button class="btn btn-g btn-sm" type="submit" style="color:#C03A28;border-color:#F7C9C2">حذف</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

</main></div></body></html>
