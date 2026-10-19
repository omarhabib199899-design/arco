<?php
require_once __DIR__ . '/includes/functions.php';
$PROJECTS = require __DIR__ . '/lang/projects.php';
$PAGE_TITLE = $RTL ? 'الرئيسية' : 'Home';
$PAGE_DESC  = t('hero_text');
require __DIR__ . '/includes/header.php';
?>

<!-- ============ HERO ============ -->
<section class="hero">
  <div class="container">
    <div class="hero-grid">
      <div>
        <span class="hero-tag"><i></i><?= t('hero_tag') ?></span>
        <h1><?= t('hero_title') ?></h1>
        <p><?= t('hero_text') ?></p>
        <p><?= t('hero_text2') ?></p>
        <div class="hero-btns">
          <a href="services.php" class="btn btn-primary btn-lg"><?= t('hero_btn1') ?></a>
          <a href="projects.php" class="btn btn-outline-light btn-lg"><?= t('hero_btn2') ?></a>
        </div>
        <div class="hero-mini">
          <div><strong data-count="<?= count($PROJECTS) ?>" data-suffix="+">0</strong><span><?= $RTL ? 'عمل ضمن سابقة الأعمال' : 'works in our record' ?></span></div>
          <div><strong data-count="9">0</strong><span><?= $RTL ? 'خدمات متخصصة' : 'specialised services' ?></span></div>
          <div><strong data-count="13" data-suffix="+">0</strong><span><?= $RTL ? 'جهة تعاونّا معها' : 'clients &amp; partners' ?></span></div>
        </div>
      </div>

      <div class="hero-card reveal">
        <h3><?= $RTL ? 'نطاقات أعمالنا' : 'Our Work Scopes' ?></h3>
        <ul>
          <?php foreach ([1,3,4,5,6,9] as $i): ?>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m20 6-11 11-5-5"/></svg>
            <span><?= t('srv' . $i . '_t') ?></span>
          </li>
          <?php endforeach; ?>
        </ul>
        <a href="booking.php" class="btn btn-primary btn-block" style="margin-top:24px"><?= t('hero_btn3') ?></a>
      </div>
    </div>
  </div>
</section>

<!-- ============ ABOUT ============ -->
<section class="section" id="about">
  <div class="container">
    <div class="split">
      <div class="split-media reveal">
        <div class="frame"><img src="assets/img/logo.jpg" alt="ARCO"></div>
        <div class="badge"><strong>ARCO</strong><span><?= t('brand_sub') ?></span></div>
      </div>
      <div class="split-body reveal">
        <span class="kicker"><?= t('about_kicker') ?></span>
        <h2><?= t('about_title') ?></h2>
        <div class="rule" style="margin-bottom:22px"></div>
        <p><?= t('about_p1') ?></p>
        <p><?= t('about_p2') ?></p>
        <p><?= t('about_p5') ?></p>
        <div class="chips">
          <?php foreach ([3,4,5,6,7,8] as $i): ?>
            <span class="chip"><?= t('srv' . $i . '_t') ?></span>
          <?php endforeach; ?>
        </div>
        <a href="about.php" class="btn btn-navy" style="margin-top:28px"><?= t('nav_about') ?></a>
      </div>
    </div>
  </div>
</section>

<!-- ============ SERVICES ============ -->
<section class="section section--alt">
  <div class="container">
    <div class="sec-head center">
      <span class="kicker"><?= t('srv_kicker') ?></span>
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
    <div style="text-align:center;margin-top:44px">
      <a href="services.php" class="btn btn-navy btn-lg"><?= t('nav_services') ?></a>
    </div>
  </div>
</section>

<!-- ============ STATS ============ -->
<section class="section section--navy">
  <div class="container">
    <div class="sec-head center">
      <span class="kicker"><?= t('stats_kicker') ?></span>
      <h2><?= $RTL ? 'خبرة تُقاس بالتنفيذ' : 'Experience Measured by Delivery' ?></h2>
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

<!-- ============ FEATURED PROJECTS ============ -->
<section class="section">
  <div class="container">
    <div class="sec-head center">
      <span class="kicker"><?= t('prj_kicker') ?></span>
      <h2><?= t('prj_title') ?></h2>
      <p><?= t('prj_intro') ?></p>
      <div class="rule"></div>
    </div>
    <div class="grid grid-3">
      <?php foreach (array_slice(featured_projects(), 0, 6) as $p): ?>
      <div class="prj-card reveal">
        <div class="prj-top">
          <span class="prj-tag"><?= $p['r'] === 'nc' ? t('prj_region1') : t('prj_region2') ?></span>
          <h3><?= e($p['n']) ?></h3>
        </div>
        <div class="prj-body"><?= pick($p) ?></div>
      </div>
      <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:44px">
      <a href="projects.php" class="btn btn-primary btn-lg"><?= t('hero_btn2') ?></a>
    </div>
  </div>
</section>

<!-- ============ WHY ARCO ============ -->
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

<!-- ============ PARTNERS ============ -->
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
    <p style="text-align:center;margin-top:30px;color:var(--muted)"><?= t('ptn_note') ?></p>
  </div>
</section>

<!-- ============ REAL ESTATE ============ -->
<section class="section section--alt">
  <div class="container">
    <div class="split">
      <div class="split-body reveal">
        <span class="kicker"><?= t('re_kicker') ?></span>
        <h2><?= t('re_title') ?></h2>
        <div class="rule" style="margin-bottom:22px"></div>
        <p><?= t('re_p1') ?></p>
        <p><?= t('re_p2') ?></p>
        <a href="realestate.php" class="btn btn-navy" style="margin-top:14px"><?= t('read_more') ?></a>
      </div>
      <div class="reveal">
        <div class="form-card">
          <h3 style="margin-bottom:20px;font-size:1.2rem"><?= t('re_list_t') ?></h3>
          <ul>
            <?php for ($i = 1; $i <= 7; $i++): ?>
            <li style="display:flex;gap:12px;padding:11px 0;border-bottom:1px solid var(--line);font-size:.95rem">
              <svg viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" style="width:19px;height:19px;flex:none;margin-top:3px"><path d="m20 6-11 11-5-5"/></svg>
              <span><?= t('re_l' . $i) ?></span>
            </li>
            <?php endfor; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ CTA ============ -->
<section class="cta">
  <div class="container">
    <span class="kicker"><?= t('cta_kicker') ?></span>
    <h2><?= t('cta_title') ?></h2>
    <p><?= t('cta_p1') ?></p>
    <p><strong style="color:#fff"><?= t('cta_p2') ?></strong></p>
    <div class="cta-btns">
      <a href="booking.php" class="btn btn-primary btn-lg"><?= t('hero_btn3') ?></a>
      <a href="https://wa.me/<?= e(SITE_WHATSAPP) ?>" target="_blank" rel="noopener" class="btn btn-wa btn-lg"><?= t('whatsapp') ?></a>
      <a href="tel:<?= e(SITE_PHONE) ?>" class="btn btn-outline-light btn-lg"><?= t('call_now') ?></a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
