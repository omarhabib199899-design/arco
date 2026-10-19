<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/db.php';

$PAGE_TITLE = t('nav_booking');
$PAGE_DESC  = t('bk_intro');

$errors  = [];
$done    = false;
$refNo   = '';
$old     = ['name'=>'','phone'=>'','email'=>'','service'=>($_GET['service'] ?? ''),
            'ptype'=>'','location'=>'','pref_date'=>'','pref_time'=>'','mode'=>'bk_mode1','notes'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    foreach ($old as $k => $v) { $old[$k] = trim((string)($_POST[$k] ?? $v)); }

    if (!csrf_ok()) {
        $errors[] = $RTL ? 'انتهت صلاحية الجلسة، برجاء إعادة المحاولة.' : 'Session expired, please try again.';
    }

    /* required */
    if ($old['name'] === '' || $old['phone'] === '' || $old['service'] === '' || $old['pref_date'] === '' || $old['pref_time'] === '') {
        $errors[] = t('bk_err_req');
    }

    /* phone */
    $digits = preg_replace('/\D+/', '', $old['phone']);
    if ($old['phone'] !== '' && strlen($digits) < 8) $errors[] = t('bk_err_phone');

    /* email */
    if ($old['email'] !== '' && !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = $RTL ? 'برجاء إدخال بريد إلكتروني صحيح.' : 'Please enter a valid email address.';
    }

    /* date: today or later, not the weekly off-day */
    if ($old['pref_date'] !== '') {
        $d = DateTime::createFromFormat('Y-m-d', $old['pref_date']);
        $ok = $d && $d->format('Y-m-d') === $old['pref_date'];
        if ($ok) {
            $today = new DateTime('today');
            if ($d < $today || (int)$d->format('w') === WORK_OFF_DAY) $ok = false;
        }
        if (!$ok) $errors[] = t('bk_err_date');
    }

    if (!$errors) {
        $refNo = 'ARC-' . date('ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));
        try {
            $st = db()->prepare(
                'INSERT INTO appointments
                 (ref_no, name, phone, email, service, project_type, location, pref_date, pref_time, meet_mode, notes, lang, ip, status, created_at)
                 VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?, "new", NOW())'
            );
            $st->execute([
                $refNo, $old['name'], $old['phone'], $old['email'],
                strip_tags(t($old['service'] . '_t')) ?: $old['service'],
                $old['ptype'] !== '' ? strip_tags(t($old['ptype'])) : '',
                $old['location'], $old['pref_date'], $old['pref_time'],
                strip_tags(t($old['mode'])), $old['notes'], $LANG,
                $_SERVER['REMOTE_ADDR'] ?? '',
            ]);
            $done = true;

            if (NOTIFY_EMAIL !== '') {
                $body = "New appointment request\n\n"
                      . "Ref: $refNo\nName: {$old['name']}\nPhone: {$old['phone']}\nEmail: {$old['email']}\n"
                      . "Service: {$old['service']}\nDate: {$old['pref_date']} {$old['pref_time']}\n"
                      . "Location: {$old['location']}\nNotes: {$old['notes']}\n";
                @mail(NOTIFY_EMAIL, 'ARCO - New appointment ' . $refNo, $body,
                      "Content-Type: text/plain; charset=UTF-8\r\nFrom: " . SITE_EMAIL);
            }
        } catch (Throwable $ex) {
            $errors[] = $RTL ? 'تعذّر حفظ الطلب حاليًا، برجاء التواصل هاتفيًا.' : 'Could not save your request right now, please contact us by phone.';
        }
    }
}

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="container">
    <div class="crumbs"><a href="index.php"><?= t('nav_home') ?></a><span>/</span><span><?= t('nav_booking') ?></span></div>
    <h1><?= t('bk_title') ?></h1>
    <p><?= t('bk_intro') ?></p>
  </div>
</section>

<section class="section">
  <div class="container">

  <?php if ($done): ?>
    <div class="success-box reveal in">
      <div class="tick">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="m20 6-11 11-5-5"/></svg>
      </div>
      <h2><?= t('bk_ok_t') ?></h2>
      <p><?= t('bk_ok_p') ?></p>
      <div><span style="font-size:.88rem;color:var(--muted)"><?= t('bk_ref') ?></span></div>
      <div class="ref-no" dir="ltr"><?= e($refNo) ?></div>
      <div class="hero-btns" style="justify-content:center">
        <a href="index.php" class="btn btn-navy"><?= t('back_home') ?></a>
        <a href="https://wa.me/<?= e(SITE_WHATSAPP) ?>?text=<?= rawurlencode(($RTL ? 'مرحبًا، طلب حجز رقم ' : 'Hello, booking request ') . $refNo) ?>" target="_blank" rel="noopener" class="btn btn-wa"><?= t('whatsapp') ?></a>
      </div>
    </div>

  <?php else: ?>

    <div class="split" style="align-items:flex-start;gap:44px">

      <!-- Form -->
      <div class="split-body" style="grid-column:span 1">
        <?php if ($errors): ?>
          <div class="alert alert-err">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16.5v.01"/></svg>
            <span><?= implode(' ', array_map('e', $errors)) ?></span>
          </div>
        <?php endif; ?>

        <form method="post" class="form-card" novalidate>
          <?= csrf_field() ?>
          <div class="form-grid">

            <div class="field">
              <label for="name"><?= t('bk_name') ?> <b>*</b></label>
              <input type="text" id="name" name="name" value="<?= e($old['name']) ?>" required
                     placeholder="<?= $RTL ? 'اكتب اسمك' : 'Your name' ?>">
            </div>

            <div class="field">
              <label for="phone"><?= t('bk_phone') ?> <b>*</b></label>
              <input type="tel" id="phone" name="phone" value="<?= e($old['phone']) ?>" required dir="ltr"
                     placeholder="01xxxxxxxxx">
            </div>

            <div class="field">
              <label for="email"><?= t('bk_email') ?></label>
              <input type="email" id="email" name="email" value="<?= e($old['email']) ?>" dir="ltr"
                     placeholder="name@example.com">
            </div>

            <div class="field">
              <label for="service"><?= t('bk_service') ?> <b>*</b></label>
              <select id="service" name="service" required>
                <option value=""><?= t('bk_choose') ?></option>
                <?php for ($i = 1; $i <= 9; $i++): $k = 'srv' . $i; ?>
                <option value="<?= $k ?>" <?= $old['service'] === $k ? 'selected' : '' ?>><?= t($k . '_t') ?></option>
                <?php endfor; ?>
              </select>
            </div>

            <div class="field">
              <label for="ptype"><?= t('bk_type') ?></label>
              <select id="ptype" name="ptype">
                <option value=""><?= t('bk_choose') ?></option>
                <?php for ($i = 1; $i <= 5; $i++): $k = 'bk_type' . $i; ?>
                <option value="<?= $k ?>" <?= $old['ptype'] === $k ? 'selected' : '' ?>><?= t($k) ?></option>
                <?php endfor; ?>
              </select>
            </div>

            <div class="field">
              <label for="location"><?= t('bk_location') ?></label>
              <input type="text" id="location" name="location" value="<?= e($old['location']) ?>"
                     placeholder="<?= $RTL ? 'مثال: الساحل الشمالي – هاسيندا باي' : 'e.g. North Coast – Hacienda Bay' ?>">
            </div>

            <div class="field">
              <label for="pref_date"><?= t('bk_date') ?> <b>*</b></label>
              <input type="date" id="pref_date" name="pref_date" value="<?= e($old['pref_date']) ?>" required
                     data-offday="<?= (int)WORK_OFF_DAY ?>">
              <small id="dateWarn" style="display:none;color:#C03A28;font-size:.84rem;font-weight:700">
                <?= $RTL ? 'يوم الجمعة إجازة — برجاء اختيار يوم آخر.' : 'Friday is our day off — please pick another day.' ?>
              </small>
            </div>

            <div class="field">
              <label for="pref_time"><?= t('bk_time') ?> <b>*</b></label>
              <select id="pref_time" name="pref_time" required>
                <option value=""><?= t('bk_choose') ?></option>
                <?php for ($h = WORK_START; $h < WORK_END; $h++):
                        foreach ([0, 30] as $m):
                          $v = sprintf('%02d:%02d', $h, $m);
                          $ampm = $h < 12 ? ($RTL ? 'ص' : 'AM') : ($RTL ? 'م' : 'PM');
                          $h12  = $h % 12 === 0 ? 12 : $h % 12;
                          $lbl  = sprintf('%d:%02d %s', $h12, $m, $ampm); ?>
                <option value="<?= $v ?>" <?= $old['pref_time'] === $v ? 'selected' : '' ?>><?= $lbl ?></option>
                <?php   endforeach;
                      endfor; ?>
              </select>
            </div>

            <div class="field full">
              <label><?= t('bk_mode') ?></label>
              <div class="radio-row">
                <?php for ($i = 1; $i <= 4; $i++): $k = 'bk_mode' . $i; ?>
                <label class="radio-pill">
                  <input type="radio" name="mode" value="<?= $k ?>" <?= $old['mode'] === $k ? 'checked' : '' ?>>
                  <span><?= t($k) ?></span>
                </label>
                <?php endfor; ?>
              </div>
            </div>

            <div class="field full">
              <label for="notes"><?= t('bk_notes') ?></label>
              <textarea id="notes" name="notes" placeholder="<?= $RTL ? 'اكتب نطاق الأعمال، المساحة التقريبية، أو أي تفاصيل تساعدنا.' : 'Describe the scope, approximate area, or any detail that helps us.' ?>"><?= e($old['notes']) ?></textarea>
            </div>

            <div class="field full">
              <button type="submit" class="btn btn-primary btn-lg btn-block">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18M9 16l2 2 4-4"/></svg>
                <?= t('bk_submit') ?>
              </button>
            </div>

          </div>
        </form>
      </div>

      <!-- Side -->
      <div>
        <div class="form-card reveal" style="margin-bottom:24px">
          <h3 style="font-size:1.15rem;margin-bottom:20px"><?= t('bk_why_t') ?></h3>
          <?php for ($i = 1; $i <= 4; $i++): ?>
          <div style="display:flex;gap:14px;padding:13px 0;border-bottom:<?= $i < 4 ? '1px solid var(--line)' : '0' ?>">
            <i style="width:30px;height:30px;border-radius:50%;background:var(--blue);color:#fff;display:grid;place-items:center;font-style:normal;font-weight:900;font-size:.85rem;flex:none"><?= $i ?></i>
            <span style="font-size:.93rem"><?= t('bk_s' . $i) ?></span>
          </div>
          <?php endfor; ?>
        </div>

        <div class="info-card reveal" style="margin-bottom:14px">
          <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg></div>
          <div><strong><?= t('ct_phone') ?></strong><a href="tel:<?= e(SITE_PHONE) ?>"><?= e(SITE_PHONE) ?></a></div>
        </div>

        <div class="info-card reveal" style="margin-bottom:14px">
          <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div>
          <div><strong><?= t('ct_hours') ?></strong><span style="direction:inherit"><?= t('ct_hours_v') ?></span></div>
        </div>

        <a href="https://wa.me/<?= e(SITE_WHATSAPP) ?>" target="_blank" rel="noopener" class="btn btn-wa btn-block btn-lg">
          <?= t('whatsapp') ?>
        </a>
      </div>

    </div>

  <?php endif; ?>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
