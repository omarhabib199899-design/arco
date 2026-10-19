<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/db.php';

$PAGE_TITLE = t('nav_contact');
$PAGE_DESC  = t('cta_p1');

$errors = [];
$sent   = false;
$old    = ['name'=>'','phone'=>'','email'=>'','subject'=>'','message'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($old as $k => $v) { $old[$k] = trim((string)($_POST[$k] ?? '')); }

    if (!csrf_ok()) $errors[] = $RTL ? 'انتهت صلاحية الجلسة، برجاء إعادة المحاولة.' : 'Session expired, please try again.';
    if ($old['name'] === '' || $old['phone'] === '' || $old['message'] === '') $errors[] = t('bk_err_req');
    if ($old['email'] !== '' && !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = $RTL ? 'برجاء إدخال بريد إلكتروني صحيح.' : 'Please enter a valid email address.';
    }

    if (!$errors) {
        try {
            $st = db()->prepare('INSERT INTO messages (name, phone, email, subject, body, lang, ip, status, created_at)
                                 VALUES (?,?,?,?,?,?,?, "new", NOW())');
            $st->execute([$old['name'], $old['phone'], $old['email'], $old['subject'], $old['message'],
                          $LANG, $_SERVER['REMOTE_ADDR'] ?? '']);
            $sent = true;
            $old  = array_map(function () { return ''; }, $old);

            if (NOTIFY_EMAIL !== '') {
                @mail(NOTIFY_EMAIL, 'ARCO - New message',
                      "Name: {$_POST['name']}\nPhone: {$_POST['phone']}\nEmail: {$_POST['email']}\n\n{$_POST['message']}",
                      "Content-Type: text/plain; charset=UTF-8\r\nFrom: " . SITE_EMAIL);
            }
        } catch (Throwable $ex) {
            $errors[] = $RTL ? 'تعذّر إرسال الرسالة حاليًا، برجاء التواصل هاتفيًا.' : 'Could not send the message right now, please contact us by phone.';
        }
    }
}

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="container">
    <div class="crumbs"><a href="index.php"><?= t('nav_home') ?></a><span>/</span><span><?= t('nav_contact') ?></span></div>
    <h1><?= t('cta_title') ?></h1>
    <p><?= t('cta_p1') ?></p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid grid-4" style="margin-bottom:56px">
      <div class="info-card reveal">
        <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg></div>
        <div>
          <strong><?= t('ct_phone') ?></strong>
          <a href="tel:<?= e(SITE_PHONE) ?>"><?= e(SITE_PHONE) ?></a>
          <a href="tel:<?= e(SITE_PHONE2) ?>"><?= e(SITE_PHONE2) ?></a>
        </div>
      </div>
      <div class="info-card reveal">
        <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="m4 6 8 6 8-6"/></svg></div>
        <div><strong><?= t('ct_email') ?></strong><a href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a></div>
      </div>
      <div class="info-card reveal">
        <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
        <div><strong><?= t('ct_addr') ?></strong><span style="direction:inherit"><?= $RTL ? e(SITE_ADDRESS_AR) : e(SITE_ADDRESS_EN) ?></span></div>
      </div>
      <div class="info-card reveal">
        <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div>
        <div><strong><?= t('ct_hours') ?></strong><span style="direction:inherit"><?= t('ct_hours_v') ?></span></div>
      </div>
    </div>

    <div class="split" style="align-items:flex-start">
      <div>
        <?php if ($sent): ?>
        <div class="alert alert-ok">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m20 6-11 11-5-5"/></svg>
          <span><?= t('ct_ok') ?></span>
        </div>
        <?php endif; ?>

        <?php if ($errors): ?>
        <div class="alert alert-err">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16.5v.01"/></svg>
          <span><?= implode(' ', array_map('e', $errors)) ?></span>
        </div>
        <?php endif; ?>

        <form method="post" class="form-card" novalidate>
          <?= csrf_field() ?>
          <h3 style="font-size:1.25rem;margin-bottom:24px"><?= t('ct_form_t') ?></h3>
          <div class="form-grid">
            <div class="field">
              <label for="name"><?= t('bk_name') ?> <b>*</b></label>
              <input type="text" id="name" name="name" value="<?= e($old['name']) ?>" required>
            </div>
            <div class="field">
              <label for="phone"><?= t('bk_phone') ?> <b>*</b></label>
              <input type="tel" id="phone" name="phone" value="<?= e($old['phone']) ?>" required dir="ltr" placeholder="01xxxxxxxxx">
            </div>
            <div class="field">
              <label for="email"><?= t('bk_email') ?></label>
              <input type="email" id="email" name="email" value="<?= e($old['email']) ?>" dir="ltr" placeholder="name@example.com">
            </div>
            <div class="field">
              <label for="subject"><?= $RTL ? 'الموضوع' : 'Subject' ?></label>
              <input type="text" id="subject" name="subject" value="<?= e($old['subject']) ?>">
            </div>
            <div class="field full">
              <label for="message"><?= t('ct_msg') ?> <b>*</b></label>
              <textarea id="message" name="message" required><?= e($old['message']) ?></textarea>
            </div>
            <div class="field full">
              <button type="submit" class="btn btn-primary btn-lg btn-block"><?= t('ct_send') ?></button>
            </div>
          </div>
        </form>
      </div>

      <div>
        <div class="form-card" style="padding:0;overflow:hidden">
          <iframe
            src="https://www.google.com/maps?q=Cairo,Egypt&output=embed"
            width="100%" height="420" style="border:0;display:block" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade" title="ARCO location"></iframe>
        </div>
        <div class="hero-btns" style="margin-top:20px">
          <a href="booking.php" class="btn btn-navy btn-lg"><?= t('hero_btn3') ?></a>
          <a href="https://wa.me/<?= e(SITE_WHATSAPP) ?>" target="_blank" rel="noopener" class="btn btn-wa btn-lg"><?= t('whatsapp') ?></a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
