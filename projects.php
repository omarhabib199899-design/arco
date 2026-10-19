<?php
require_once __DIR__ . '/includes/functions.php';
$PROJECTS = require __DIR__ . '/lang/projects.php';
$PAGE_TITLE = t('nav_projects');
$PAGE_DESC  = t('prj_intro');
require __DIR__ . '/includes/header.php';

$regions = [
  'all' => t('prj_filter_all'),
  'nc'  => t('prj_region1'),
  'cc'  => t('prj_region2'),
  'ot'  => ($RTL ? 'مشروعات أخرى' : 'Other Projects'),
];
?>

<section class="page-hero">
  <div class="container">
    <div class="crumbs"><a href="index.php"><?= t('nav_home') ?></a><span>/</span><span><?= t('nav_projects') ?></span></div>
    <h1><?= t('prj_title') ?></h1>
    <p><?= t('prj_intro') ?></p>
    <a href="#approvals" class="hero-jump">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l2 2 4-4"/><path d="M20 12a8 8 0 1 1-4.6-7.2"/></svg>
      <span><?= t('apv_kicker') ?></span>
      <strong><?= count(approvals_list()) ?></strong>
    </a>
  </div>
</section>

<!-- ===== Featured cards ===== -->
<section class="section">
  <div class="container">
    <div class="sec-head center">
      <span class="kicker"><?= t('prj_kicker') ?></span>
      <h2><?= $RTL ? 'أبرز المشروعات' : 'Highlighted Projects' ?></h2>
      <div class="rule"></div>
    </div>

    <div class="filters">
      <?php $first = true; foreach ($regions as $k => $label): ?>
      <button class="filter <?= $first ? 'active' : '' ?>" data-filter="<?= $k ?>"><?= $label ?></button>
      <?php $first = false; endforeach; ?>
    </div>
    <p style="margin:-16px 0 26px;font-size:.88rem;color:var(--muted)">
      <?= $RTL ? 'الفلتر يطبّق على البطاقات وجدول سابقة الأعمال معًا.' : 'The filter applies to both the cards and the track-record table.' ?>
    </p>

    <div class="grid grid-3">
      <?php foreach (featured_projects() as $p): ?>
      <div class="prj-card reveal" data-card data-region="<?= e($p['r']) ?>">
        <div class="prj-top">
          <span class="prj-tag"><?= $p['r'] === 'nc' ? t('prj_region1') : t('prj_region2') ?></span>
          <h3><?= e($p['n']) ?></h3>
        </div>
        <div class="prj-body"><?= pick($p) ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===== Full track record table ===== -->
<section class="section section--alt">
  <div class="container">
    <div class="sec-head center">
      <span class="kicker"><?= $RTL ? 'سابقة الأعمال' : 'Track Record' ?></span>
      <h2><?= t('prj_table_t') ?></h2>
      <p><?= count($PROJECTS) ?> <?= $RTL ? 'عملًا موثقًا ضمن سابقة أعمال الشركة' : 'documented works in the company record' ?></p>
      <div class="rule"></div>
    </div>

    <div class="filters">
      <div class="search-box">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="text" id="prjSearch" placeholder="<?= e(strip_tags(t('prj_search'))) ?>">
      </div>
    </div>

    <div class="table-wrap">
      <div style="overflow-x:auto">
        <table class="tbl">
          <thead>
            <tr>
              <th><?= t('prj_th_client') ?></th>
              <th><?= t('prj_th_site') ?></th>
              <th><?= t('prj_th_scope') ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($PROJECTS as $row): ?>
            <tr data-row data-region="<?= e($row['r']) ?>">
              <td><?= pick($row['c']) ?></td>
              <td><?= pick($row['s']) ?></td>
              <td><?= pick($row['w']) ?></td>
            </tr>
            <?php endforeach; ?>
            <tr class="empty-row" id="emptyRow" style="display:none"><td colspan="3"><?= t('prj_none') ?></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- ===== Approvals & certificates ===== -->
<section class="section" id="approvals">
  <div class="container">
    <div class="sec-head center">
      <span class="kicker"><?= t('apv_kicker') ?></span>
      <h2><?= t('apv_title') ?></h2>
      <p><?= t('apv_intro') ?></p>
      <p style="margin-top:6px"><strong style="color:var(--blue-700)"><?= count(approvals_list()) ?></strong> <?= t('apv_count') ?></p>
      <div class="rule"></div>
    </div>

    <div class="filters">
      <?php foreach (approval_groups() as $k => $label): ?>
      <button class="filter <?= $k === 'all' ? 'active' : '' ?>" data-apv-filter="<?= e($k) ?>"><?= $label ?></button>
      <?php endforeach; ?>
    </div>

    <div class="apv-grid">
      <?php foreach (approvals_list() as $a):
        $client = pick($a['client']);
        $proj   = pick($a['project']);
        $doc    = pick($a['doc']);
        $ref    = is_array($a['ref']) ? pick($a['ref']) : $a['ref'];
        $by     = is_array($a['by'])  ? pick($a['by'])  : $a['by'];
        $cap    = $client . ' — ' . $proj;
        $dim    = @getimagesize(__DIR__ . '/assets/img/approvals/' . $a['img'] . '-thumb.jpg');
        $wide   = $dim && $dim[0] > $dim[1];
      ?>
      <figure class="apv-card reveal" data-apv-card data-apv-group="<?= e($a['g']) ?>">
        <button type="button" class="apv-shot<?= $wide ? ' apv-shot--wide' : '' ?>"
                data-apv-open="assets/img/approvals/<?= e($a['img']) ?>.jpg"
                data-apv-cap="<?= attr($cap) ?>"
                data-apv-desc="<?= attr($doc) ?>"
                aria-label="<?= attr(t('apv_view') . ' — ' . $cap) ?>">
          <img src="assets/img/approvals/<?= e($a['img']) ?>-thumb.jpg" alt="<?= attr($cap) ?>" loading="lazy">
          <span class="apv-hover">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3M11 8v6M8 11h6"/></svg>
            <span><?= t('apv_view') ?></span>
          </span>
          <?php if (!empty($a['status'])): ?>
          <span class="apv-badge"><?= pick($a['status']) ?></span>
          <?php endif; ?>
        </button>

        <figcaption class="apv-info">
          <h3><?= $client ?></h3>
          <span class="apv-prj"><?= $proj ?></span>
          <p><?= $doc ?></p>
          <div class="apv-meta">
            <?php if ($ref): ?><span class="apv-chip" dir="<?= preg_match('/^[\x20-\x7E]+$/', $ref) ? 'ltr' : $DIR ?>"><?= $ref ?></span><?php endif; ?>
            <?php if (!empty($a['date'])): ?><span class="apv-chip apv-chip--date" dir="ltr"><?= e($a['date']) ?></span><?php endif; ?>
          </div>
          <?php if ($by): ?><span class="apv-by"><?= $by ?></span><?php endif; ?>
        </figcaption>
      </figure>
      <?php endforeach; ?>
    </div>

    <p class="apv-empty" id="apvEmpty" style="display:none"><?= t('apv_none') ?></p>
    <p class="apv-note"><?= t('apv_note') ?></p>
  </div>
</section>

<!-- Lightbox -->
<div class="lb" id="apvLb" hidden>
  <div class="lb-bar">
    <span class="lb-count" id="lbCount"></span>
    <button type="button" class="lb-btn" id="lbClose" aria-label="<?= attr(t('apv_close')) ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6 6 18"/></svg>
    </button>
  </div>
  <button type="button" class="lb-nav lb-prev" id="lbPrev" aria-label="<?= attr(t('apv_prev')) ?>">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 5-7 7 7 7"/></svg>
  </button>
  <button type="button" class="lb-nav lb-next" id="lbNext" aria-label="<?= attr(t('apv_next')) ?>">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 5 7 7-7 7"/></svg>
  </button>
  <figure class="lb-stage">
    <img id="lbImg" src="" alt="">
    <figcaption class="lb-cap">
      <strong id="lbTitle"></strong>
      <span id="lbDesc"></span>
      <a id="lbFull" href="#" target="_blank" rel="noopener"><?= t('apv_open') ?></a>
    </figcaption>
  </figure>
</div>

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
    <p style="text-align:center;margin-top:30px;color:var(--muted)"><?= t('ptn_note') ?></p>
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
