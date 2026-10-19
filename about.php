<?php
require_once __DIR__ . '/includes/functions.php';
$PROJECTS = require __DIR__ . '/lang/projects.php';
$PAGE_TITLE = t('nav_about');
$PAGE_DESC  = t('about_p1');
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="container">
    <div class="crumbs"><a href="index.php"><?= t('nav_home') ?></a><span>/</span><span><?= t('nav_about') ?></span></div>
    <h1><?= t('about_kicker') ?></h1>
    <p><?= t('about_title') ?> — <?= t('about_former') ?></p>
  </div>
</section>

<!-- ===== Story ===== -->
<section class="section">
  <div class="container">
    <div class="split">
      <div class="split-body reveal">
        <span class="kicker"><?= t('about_kicker') ?></span>
        <h2><?= t('about_title') ?></h2>
        <div class="rule" style="margin-bottom:22px"></div>
        <p><?= t('about_p1') ?></p>
        <p><?= t('about_p2') ?></p>
        <p><?= t('about_p3') ?></p>
        <p><?= t('about_p4') ?></p>
        <p><strong style="color:var(--navy)"><?= t('about_p5') ?></strong></p>
      </div>
      <div class="split-media reveal">
        <div class="frame"><img src="assets/img/logo.jpg" alt="ARCO"></div>
        <div class="badge"><strong><?= count($PROJECTS) ?>+</strong><span><?= $RTL ? 'عمل ضمن سابقة الأعمال' : 'works in our record' ?></span></div>
      </div>
    </div>
  </div>
</section>

<!-- ===== Vision / Mission ===== -->
<section class="section section--alt">
  <div class="container">
    <div class="sec-head center">
      <span class="kicker"><?= $RTL ? 'رؤيتنا ورسالتنا' : 'Vision &amp; Mission' ?></span>
      <h2><?= $RTL ? 'إلى أين نتجه… وكيف نعمل' : 'Where We Are Heading… and How We Work' ?></h2>
      <div class="rule"></div>
    </div>

    <div class="vm">
      <div class="vm-card blue reveal">
        <div class="vm-ico">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        </div>
        <h3><?= t('vision_t') ?></h3>
        <h4><?= t('vision_h') ?></h4>
        <p><?= t('vision_p1') ?></p>
        <p><?= t('vision_p2') ?></p>
      </div>

      <div class="vm-card reveal">
        <div class="vm-ico">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1.4" fill="currentColor"/></svg>
        </div>
        <h3><?= t('mission_t') ?></h3>
        <h4><?= $RTL ? 'خدمات متكاملة… بمعايير واضحة' : 'Integrated services… with clear standards' ?></h4>
        <p><?= t('mission_p1') ?></p>
        <p><?= t('mission_p2') ?></p>
      </div>
    </div>
  </div>
</section>

<!-- ===== Expertise ===== -->
<section class="section">
  <div class="container">
    <div class="sec-head center">
      <span class="kicker"><?= $RTL ? 'مجالات خبرتنا' : 'Our Fields of Expertise' ?></span>
      <h2><?= t('srv_title') ?></h2>
      <div class="rule"></div>
    </div>
    <div class="grid grid-3">
      <?php for ($i = 1; $i <= 9; $i++): ?>
      <div class="card reveal">
        <div class="card-ico"><?= service_icon($i) ?></div>
        <h3><?= t('srv' . $i . '_t') ?></h3>
        <p><?= t('srv' . $i . '_d') ?></p>
      </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- ===== Why ARCO ===== -->
<section class="section section--alt">
  <div class="container">
    <div class="sec-head center">
      <span class="kicker"><?= t('why_kicker') ?></span>
      <h2><?= t('why_title') ?></h2>
      <div class="rule"></div>
    </div>
    <div class="grid grid-3">
      <?php for ($i = 1; $i <= 6; $i++): ?>
      <div class="card reveal">
        <div class="card-num"><?= str_pad((string)$i, 2, '0', STR_PAD_LEFT) ?></div>
        <h3><?= t('why' . $i . '_t') ?></h3>
        <p><?= t('why' . $i . '_d') ?></p>
      </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- ===== Stats ===== -->
<section class="section section--navy">
  <div class="container">
    <div class="sec-head center">
      <span class="kicker"><?= t('stats_kicker') ?></span>
      <h2><?= $RTL ? 'نظرة سريعة على نشاط الشركة' : 'A Quick Look at Our Activity' ?></h2>
      <div class="rule"></div>
    </div>
    <div class="stats">
      <?php
      $statIcons = [
        '<path d="M3 21h18M5 21V8l7-5 7 5v13"/>',
        '<path d="M4 4h7v7H4zM13 4h7v7h-7zM4 13h7v7H4zM13 13h7v7h-7z"/>',
        '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM23 21v-2a4 4 0 0 0-3-3.9M16 3.1a4 4 0 0 1 0 7.8"/>',
        '<path d="M12 2 2 7l10 5 10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>',
      ];
      for ($i = 1; $i <= 4; $i++): ?>
      <div class="stat">
        <div class="stat-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><?= $statIcons[$i-1] ?></svg></div>
        <strong><?= t('st' . $i . '_t') ?></strong>
        <span><?= t('st' . $i . '_d') ?></span>
      </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- ===== Partners ===== -->
<section class="section">
  <div class="container">
    <div class="sec-head center">
      <span class="kicker"><?= t('ptn_kicker') ?></span>
      <h2><?= t('ptn_title') ?></h2>
      <p><?= t('ptn_intro') ?></p>
      <div class="rule"></div>
    </div>
    <div class="partners">
      <?php foreach (partners_list() as $p): ?>
      <div class="partner reveal"><i><?= e(mb_substr($p, 0, 1, 'UTF-8')) ?></i><span><?= e($p) ?></span></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="cta">
  <div class="container">
    <h2><?= t('cta_title') ?></h2>
    <p><?= t('cta_p1') ?></p>
    <div class="cta-btns">
      <a href="booking.php" class="btn btn-primary btn-lg"><?= t('hero_btn3') ?></a>
      <a href="contact.php" class="btn btn-outline-light btn-lg"><?= t('nav_contact') ?></a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
