<?php
require_once __DIR__ . '/includes/functions.php';
$PAGE_TITLE = t('nav_services');
$PAGE_DESC  = t('srv_title');
require __DIR__ . '/includes/header.php';

/* تفاصيل إضافية لكل خدمة */
$details = [
 1 => [['ar'=>'إدارة وتنسيق أعمال الموقع','en'=>'Site management and coordination'],['ar'=>'تنفيذ الأعمال الإنشائية','en'=>'Structural works execution'],['ar'=>'متابعة الجودة والجداول الزمنية','en'=>'Quality and schedule follow-up'],['ar'=>'التسليم على مراحل','en'=>'Phased handover']],
 2 => [['ar'=>'تشطيبات داخلية وخارجية','en'=>'Interior and exterior finishing'],['ar'=>'أرضيات وسيراميك وبورسلين','en'=>'Flooring, ceramic and porcelain'],['ar'=>'أعمال حجر هشمي وواجهات','en'=>'Hashmi stone and facade works'],['ar'=>'تسليم مفتاح','en'=>'Turnkey delivery']],
 3 => [['ar'=>'أسقف معلقة وديكورات جبسية','en'=>'Suspended ceilings and gypsum detailing'],['ar'=>'حوائط وقواطع','en'=>'Walls and partitions'],['ar'=>'ألواح وبلاطات جبسية وأسمنتية','en'=>'Gypsum and cement boards and tiles'],['ar'=>'أبواب كشف للصيانة','en'=>'Access doors for maintenance']],
 4 => [['ar'=>'مداخل وواجهات سيكوريت','en'=>'Securit entrances and facades'],['ar'=>'شاورات الحمامات','en'=>'Bathroom shower enclosures'],['ar'=>'هاندريل سيكوريت وتربلكس','en'=>'Securit and triplex handrails'],['ar'=>'مرايات وتراسات زجاجية','en'=>'Mirrors and glass terraces']],
 5 => [['ar'=>'هاندريل السلالم والبلكونات','en'=>'Staircase and balcony handrails'],['ar'=>'أسوار ومظلات معدنية','en'=>'Metal fences and canopies'],['ar'=>'أعمال كلادينج ولوفر','en'=>'Cladding and louver works'],['ar'=>'تصنيع وتركيب بالموقع','en'=>'Fabrication and on-site installation']],
 6 => [['ar'=>'شبابيك وأبواب ألومنيوم','en'=>'Aluminium windows and doors'],['ar'=>'قطاعات (PS) وقواطع','en'=>'PS profiles and partitions'],['ar'=>'هاندريل ألومنيوم','en'=>'Aluminium handrails'],['ar'=>'أنظمة سحب وفتح متنوعة','en'=>'Sliding and hinged systems']],
 7 => [['ar'=>'دهانات داخلية وخارجية','en'=>'Interior and exterior paint'],['ar'=>'معالجة وتجهيز الأسطح','en'=>'Surface preparation and treatment'],['ar'=>'أعمال إيبوكسي','en'=>'Epoxy works'],['ar'=>'دهانات المشروعات الكبرى','en'=>'Large-scale project painting']],
 8 => [['ar'=>'أعمال خرسانية متنوعة','en'=>'Various concrete works'],['ar'=>'إنترلوك وبلدورات','en'=>'Interlock paving and kerbstones'],['ar'=>'تجهيز وتسوية المواقع','en'=>'Site preparation and levelling'],['ar'=>'أعمال اللاند سكيب المرتبطة','en'=>'Associated landscape works']],
 9 => [['ar'=>'تسويق المشروعات والوحدات','en'=>'Marketing of projects and units'],['ar'=>'التسويق الرقمي للعقارات','en'=>'Digital real estate marketing'],['ar'=>'الوصول للعملاء المستهدفين','en'=>'Reaching targeted clients'],['ar'=>'خدمات للملاك والمطورين','en'=>'Services for owners and developers']],
];
?>

<section class="page-hero">
  <div class="container">
    <div class="crumbs"><a href="index.php"><?= t('nav_home') ?></a><span>/</span><span><?= t('nav_services') ?></span></div>
    <h1><?= t('srv_title') ?></h1>
    <p><?= t('about_p3') ?></p>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php for ($i = 1; $i <= 9; $i++): ?>
    <div id="srv<?= $i ?>" class="split reveal" style="margin-bottom:<?= $i < 9 ? '78px' : '0' ?>">
      <?php $mediaFirst = ($i % 2 === 0); ?>

      <?php if ($mediaFirst): ?>
      <div class="split-media">
        <div class="frame" style="aspect-ratio:5/4">
          <div style="position:relative;z-index:2;text-align:center;color:#fff">
            <div style="width:106px;height:106px;margin:0 auto 20px;border-radius:28px;background:rgba(27,157,217,.2);display:grid;place-items:center;color:#7FD0F2">
              <span class="svc-big"><?= service_icon($i) ?></span>
            </div>
            <strong style="font-size:1.25rem;display:block"><?= t('srv' . $i . '_t') ?></strong>
            <span style="opacity:.6;font-size:.85rem;letter-spacing:.2em">0<?= $i ?></span>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <div class="split-body">
        <span class="kicker"><?= $RTL ? 'خدمة' : 'Service' ?> 0<?= $i ?></span>
        <h2 style="font-size:clamp(1.4rem,2.6vw,1.95rem)"><?= t('srv' . $i . '_t') ?></h2>
        <div class="rule" style="margin-bottom:20px"></div>
        <p><?= t('srv' . $i . '_d') ?></p>
        <?php if ($i === 9): ?><p><?= t('srv9_d2') ?></p><?php endif; ?>
        <ul style="margin-top:18px">
          <?php foreach ($details[$i] as $d): ?>
          <li style="display:flex;gap:12px;padding:9px 0;font-size:.95rem">
            <svg viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" style="width:19px;height:19px;flex:none;margin-top:4px"><path d="m20 6-11 11-5-5"/></svg>
            <span><?= pick($d) ?></span>
          </li>
          <?php endforeach; ?>
        </ul>
        <a href="booking.php?service=srv<?= $i ?>" class="btn btn-primary" style="margin-top:22px"><?= t('hero_btn3') ?></a>
      </div>

      <?php if (!$mediaFirst): ?>
      <div class="split-media">
        <div class="frame" style="aspect-ratio:5/4">
          <div style="position:relative;z-index:2;text-align:center;color:#fff">
            <div style="width:106px;height:106px;margin:0 auto 20px;border-radius:28px;background:rgba(27,157,217,.2);display:grid;place-items:center;color:#7FD0F2">
              <span class="svc-big"><?= service_icon($i) ?></span>
            </div>
            <strong style="font-size:1.25rem;display:block"><?= t('srv' . $i . '_t') ?></strong>
            <span style="opacity:.6;font-size:.85rem;letter-spacing:.2em">0<?= $i ?></span>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
    <?php endfor; ?>
  </div>
</section>

<section class="cta">
  <div class="container">
    <h2><?= t('cta_title') ?></h2>
    <p><?= t('cta_p1') ?></p>
    <div class="cta-btns">
      <a href="booking.php" class="btn btn-primary btn-lg"><?= t('hero_btn3') ?></a>
      <a href="https://wa.me/<?= e(SITE_WHATSAPP) ?>" target="_blank" rel="noopener" class="btn btn-wa btn-lg"><?= t('whatsapp') ?></a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
