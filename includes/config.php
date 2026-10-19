<?php
/* ============================================================
   ARCO — Site configuration
   غيّر البيانات التالية بعد الرفع على الاستضافة (cPanel)
   ============================================================ */

/* ---- قاعدة البيانات ---- */
define('DB_HOST', 'localhost');
define('DB_NAME', 'arco_db');
define('DB_USER', 'root');          // cPanel: اسم مستخدم قاعدة البيانات
define('DB_PASS', '');              // cPanel: كلمة المرور
define('DB_CHARSET', 'utf8mb4');

/* ---- بيانات التواصل (تظهر في الموقع) ---- */
define('SITE_PHONE',    '+20 100 000 0000');
define('SITE_PHONE2',   '+20 120 000 0000');
define('SITE_WHATSAPP', '201000000000');     // بدون + أو مسافات
define('SITE_EMAIL',    'arcocontracting377@gmail.com');
define('SITE_ADDRESS_AR','القاهرة - مصر');
define('SITE_ADDRESS_EN','Cairo - Egypt');
define('SITE_MAP',      'https://maps.google.com/?q=Cairo,Egypt');

/* ---- السوشيال ---- */
define('SOC_FACEBOOK',  '#');
define('SOC_INSTAGRAM', '#');
define('SOC_LINKEDIN',  '#');

/* ---- ساعات العمل للحجز ---- */
define('WORK_START', 9);    // 9 صباحا
define('WORK_END',   18);   // 6 مساء
define('WORK_OFF_DAY', 5);  // 5 = الجمعة (0=الأحد)

/* ---- إشعار بريدي عند حجز جديد (اتركه فارغ لتعطيله) ---- */
define('NOTIFY_EMAIL', '');

/* ---- لوحة التحكم ---- */
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'Arco@2026');   // غيّرها فورًا بعد الرفع

date_default_timezone_set('Africa/Cairo');
