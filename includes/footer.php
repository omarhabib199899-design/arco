<footer class="footer">
  <div class="container">
    <div class="footer-grid">

      <div>
        <div class="footer-logo">
          <img src="assets/img/logo.jpg" alt="ARCO">
          <span><strong>ARCO</strong><span><?= t('brand_sub') ?></span></span>
        </div>
        <p><?= t('ft_about') ?></p>
        <div class="socials">
          <a href="<?= e(SOC_FACEBOOK) ?>" target="_blank" rel="noopener" aria-label="Facebook">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 9h3V6h-3c-2.2 0-4 1.8-4 4v2H8v3h2v7h3v-7h3l1-3h-4v-2c0-.6.4-1 1-1z"/></svg>
          </a>
          <a href="<?= e(SOC_INSTAGRAM) ?>" target="_blank" rel="noopener" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/></svg>
          </a>
          <a href="<?= e(SOC_LINKEDIN) ?>" target="_blank" rel="noopener" aria-label="LinkedIn">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9h4v12H3zM10 9h3.8v1.7h.1c.5-1 1.8-2 3.7-2 4 0 4.7 2.6 4.7 6V21h-4v-5.4c0-1.3 0-3-1.8-3s-2.1 1.4-2.1 2.9V21h-4z"/></svg>
          </a>
          <a href="https://wa.me/<?= e(SITE_WHATSAPP) ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.2-1.4A10 10 0 1 0 12 2zm5.3 14.1c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .1-1.7-.1a12 12 0 0 1-5.6-4.9c-.4-.7-.9-1.6-.9-2.5s.5-1.4.7-1.6a.8.8 0 0 1 .6-.2h.4c.2 0 .4 0 .6.5l.8 1.9c.1.2 0 .4-.1.5l-.3.4c-.1.2-.3.3-.1.6a9 9 0 0 0 3.9 3.3c.3.1.4.1.6-.1l.7-.8c.2-.2.3-.2.6-.1l1.8.9c.3.1.4.2.5.3z"/></svg>
          </a>
        </div>
      </div>

      <div>
        <h4><?= t('ft_links') ?></h4>
        <ul>
          <li><a href="index.php"><?= t('nav_home') ?></a></li>
          <li><a href="about.php"><?= t('nav_about') ?></a></li>
          <li><a href="services.php"><?= t('nav_services') ?></a></li>
          <li><a href="projects.php"><?= t('nav_projects') ?></a></li>
          <li><a href="realestate.php"><?= t('nav_realestate') ?></a></li>
          <li><a href="booking.php"><?= t('nav_booking') ?></a></li>
          <li><a href="contact.php"><?= t('nav_contact') ?></a></li>
        </ul>
      </div>

      <div>
        <h4><?= t('ft_srv') ?></h4>
        <ul>
          <li><a href="services.php#srv1"><?= t('srv1_t') ?></a></li>
          <li><a href="services.php#srv2"><?= t('srv2_t') ?></a></li>
          <li><a href="services.php#srv3"><?= t('srv3_t') ?></a></li>
          <li><a href="services.php#srv4"><?= t('srv4_t') ?></a></li>
          <li><a href="services.php#srv5"><?= t('srv5_t') ?></a></li>
          <li><a href="services.php#srv7"><?= t('srv7_t') ?></a></li>
          <li><a href="realestate.php"><?= t('srv9_t') ?></a></li>
        </ul>
      </div>

      <div>
        <h4><?= t('ft_contact') ?></h4>
        <ul class="f-contact">
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg>
            <span><a href="tel:<?= e(SITE_PHONE) ?>"><?= e(SITE_PHONE) ?></a><a href="tel:<?= e(SITE_PHONE2) ?>"><?= e(SITE_PHONE2) ?></a></span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="m4 6 8 6 8-6"/></svg>
            <a href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <span style="direction:inherit"><?= $RTL ? e(SITE_ADDRESS_AR) : e(SITE_ADDRESS_EN) ?></span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
            <span style="direction:inherit"><?= t('ct_hours_v') ?></span>
          </li>
        </ul>
      </div>

    </div>

    <div class="footer-bot">
      <span>&copy; <?= date('Y') ?> ARCO <?= $RTL ? 'للمقاولات العمومية والتسويق العقاري' : 'General Contracting &amp; Real Estate' ?> — <?= t('ft_rights') ?>.</span>
      <span><?= t('about_former') ?></span>
    </div>
  </div>
</footer>

<div class="fab">
  <a href="https://wa.me/<?= e(SITE_WHATSAPP) ?>" class="wa" target="_blank" rel="noopener" aria-label="WhatsApp">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.2-1.4A10 10 0 1 0 12 2zm5.3 14.1c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .1-1.7-.1a12 12 0 0 1-5.6-4.9c-.4-.7-.9-1.6-.9-2.5s.5-1.4.7-1.6a.8.8 0 0 1 .6-.2h.4c.2 0 .4 0 .6.5l.8 1.9c.1.2 0 .4-.1.5l-.3.4c-.1.2-.3.3-.1.6a9 9 0 0 0 3.9 3.3c.3.1.4.1.6-.1l.7-.8c.2-.2.3-.2.6-.1l1.8.9c.3.1.4.2.5.3z"/></svg>
  </a>
  <a href="tel:<?= e(SITE_PHONE) ?>" class="tel" aria-label="Call">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg>
  </a>
</div>

<script src="assets/js/main.js"></script>
</body>
</html>
