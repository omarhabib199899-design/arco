<?php
require_once __DIR__ . '/functions.php';
$PAGE_TITLE = $PAGE_TITLE ?? 'ARCO';
$PAGE_DESC  = $PAGE_DESC  ?? t('ft_about');
?>
<!DOCTYPE html>
<html lang="<?= $LANG ?>" dir="<?= $DIR ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($PAGE_TITLE) ?> | ARCO <?= $RTL ? 'أركو' : '' ?></title>
<meta name="description" content="<?= e(strip_tags(html_entity_decode($PAGE_DESC))) ?>">
<link rel="icon" href="assets/img/logo.jpg">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body dir="<?= $DIR ?>">

<!-- Topbar -->
<div class="topbar">
  <div class="container">
    <div class="topbar-l">
      <span class="topbar-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg>
        <a href="tel:<?= e(SITE_PHONE) ?>" dir="ltr"><?= e(SITE_PHONE) ?></a>
      </span>
      <span class="topbar-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="m4 6 8 6 8-6"/></svg>
        <a href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a>
      </span>
      <span class="topbar-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
        <?= t('ct_hours_v') ?>
      </span>
    </div>
    <div class="topbar-r">
      <span class="topbar-item"><?= $RTL ? 'مقاولات · تشطيبات · تسويق عقاري' : 'Contracting · Finishing · Real Estate' ?></span>
    </div>
  </div>
</div>

<!-- Header -->
<header class="header" id="header">
  <div class="container nav">
    <a href="index.php" class="logo">
      <img src="assets/img/logo.jpg" alt="ARCO">
      <span class="logo-txt"><strong>ARCO</strong><span><?= t('brand_sub') ?></span></span>
    </a>

    <nav class="menu" id="menu">
      <a href="index.php"    class="<?= is_page('index.php')    ? 'active' : '' ?>"><?= t('nav_home') ?></a>
      <a href="about.php"    class="<?= is_page('about.php')    ? 'active' : '' ?>"><?= t('nav_about') ?></a>
      <a href="services.php" class="<?= is_page('services.php') ? 'active' : '' ?>"><?= t('nav_services') ?></a>
      <a href="projects.php" class="<?= is_page('projects.php') ? 'active' : '' ?>"><?= t('nav_projects') ?></a>
      <a href="realestate.php" class="<?= is_page('realestate.php') ? 'active' : '' ?>"><?= t('nav_realestate') ?></a>
      <a href="contact.php"  class="<?= is_page('contact.php')  ? 'active' : '' ?>"><?= t('nav_contact') ?></a>
      <a href="booking.php"  class="<?= is_page('booking.php')  ? 'active' : '' ?>"><?= t('nav_booking') ?></a>
    </nav>

    <div class="nav-actions">
      <a href="<?= e(switch_lang_url()) ?>" class="lang-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18"/></svg>
        <?= t('lang_switch') ?>
      </a>
      <a href="booking.php" class="btn btn-primary"><?= t('nav_booking') ?></a>
      <button class="burger" id="burger" aria-label="Menu"><span></span><span></span><span></span></button>
    </div>
  </div>
</header>
