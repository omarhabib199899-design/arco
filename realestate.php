<?php
require_once __DIR__ . '/includes/functions.php';
$PAGE_TITLE = t('nav_realestate');
$PAGE_DESC  = t('re_p1');
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="container">
    <div class="crumbs"><a href="index.php"><?= t('nav_home') ?></a><span>/</span><span><?= t('nav_realestate') ?></span></div>
    <h1><?= t('re_title') ?></h1>
    <p><?= t('re_p1') ?></p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="split">
      <div class="split-body reveal">
        <span class="kicker"><?= t('re_kicker') ?></span>
        <h2><?= t('re_title') ?></h2>
        <div class="rule" style="margin-bottom:22px"></div>
        <p><?= t('re_p1') ?></p>
        <p><?= t('re_p2') ?></p>
        <p><?= t('srv9_d2') ?></p>
        <div class="hero-btns" style="margin-top:26px">
          <a href="booking.php?service=srv9" class="btn btn-primary"><?= t('hero_btn3') ?></a>
          <a href="https://wa.me/<?= e(SITE_WHATSAPP) ?>" target="_blank" rel="noopener" class="btn btn-wa"><?= t('whatsapp') ?></a>
        </div>
      </div>
      <div class="split-media reveal">
        <div class="frame"><img src="assets/img/logo.jpg" alt="ARCO"></div>
        <div class="badge"><strong><?= $RTL ? 'عقاري' : 'Real Estate' ?></strong><span><?= $RTL ? 'تسويق ومبيعات' : 'Marketing &amp; Sales' ?></span></div>
      </div>
    </div>
  </div>
</section>

<section class="section section--alt">
  <div class="container">
    <div class="sec-head center">
      <span class="kicker"><?= t('re_list_t') ?></span>
      <h2><?= $RTL ? 'ما الذي نقدمه في الجانب العقاري' : 'What We Offer on the Property Side' ?></h2>
      <div class="rule"></div>
    </div>
    <div class="grid grid-3">
      <?php
      $reIcons = [
        '<path d="M3 21h18M5 21V8l7-5 7 5v13M9 21v-6h6v6"/>',
        '<path d="M3 21h18M6 21V7h12v14M10 11h4M10 15h4"/>',
        '<path d="M3 21h18M4 21V9h7v12M13 21V4h7v17M7 13h1M7 17h1M16 8h1M16 12h1M16 16h1"/>',
        '<path d="M2 18s3-2 6-2 4 2 8 2 6-2 6-2M2 13s3-2 6-2 4 2 8 2 6-2 6-2M12 3v5"/>',
        '<path d="M4 4h16v12H4zM8 20h8M12 16v4M9 10l2 2 4-4"/>',
        '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM22 11h-6M19 8v6"/>',
        '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM22 21v-2a4 4 0 0 0-3-3.9"/>',
      ];
      for ($i = 1; $i <= 7; $i++): ?>
      <div class="card reveal">
        <div class="card-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><?= $reIcons[$i-1] ?></svg></div>
        <h3 style="font-size:1.05rem;margin-bottom:0"><?= t('re_l' . $i) ?></h3>
      </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="sec-head center">
      <span class="kicker"><?= $RTL ? 'لماذا أركو عقاريًا' : 'Why ARCO for Property' ?></span>
      <h2><?= $RTL ? 'معرفة فنية بالعقار… وخبرة بالسوق' : 'Technical Knowledge of the Property… and Market Experience' ?></h2>
      <div class="rule"></div>
    </div>
    <div class="grid grid-3">
      <div class="card reveal">
        <div class="card-num">01</div>
        <h3><?= $RTL ? 'نعرف المنتج من الداخل' : 'We Know the Product Inside Out' ?></h3>
        <p><?= $RTL ? 'خلفيتنا في التنفيذ والتشطيب تجعلنا نفهم جودة الوحدة ومواصفاتها الحقيقية قبل تسويقها.' : 'Our background in execution and finishing means we understand a unit\'s real quality and specification before marketing it.' ?></p>
      </div>
      <div class="card reveal">
        <div class="card-num">02</div>
        <h3><?= $RTL ? 'مطابقة الفرصة بالاحتياج' : 'Matching Opportunity to Need' ?></h3>
        <p><?= $RTL ? 'نساعد العميل على الوصول إلى الخيار المناسب لأهدافه، سكنيًا كان أو استثماريًا.' : 'We help clients reach the option that fits their goals, whether residential or investment.' ?></p>
      </div>
      <div class="card reveal">
        <div class="card-num">03</div>
        <h3><?= $RTL ? 'وضوح في التعامل' : 'Clarity in Dealing' ?></h3>
        <p><?= $RTL ? 'نحافظ على أعلى قدر من الوضوح والاحترافية في كل خطوة من خطوات التعامل.' : 'We maintain the highest level of clarity and professionalism at every step.' ?></p>
      </div>
    </div>
  </div>
</section>

<section class="cta">
  <div class="container">
    <h2><?= t('cta_title') ?></h2>
    <p><?= t('cta_p1') ?></p>
    <div class="cta-btns">
      <a href="booking.php?service=srv9" class="btn btn-primary btn-lg"><?= t('hero_btn3') ?></a>
      <a href="contact.php" class="btn btn-outline-light btn-lg"><?= t('nav_contact') ?></a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
