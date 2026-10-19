<?php
require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) session_start();

/* ---------- اللغة ---------- */
if (isset($_GET['lang']) && in_array($_GET['lang'], ['ar', 'en'], true)) {
    $_SESSION['lang'] = $_GET['lang'];
    $q = $_GET; unset($q['lang']);
    $url = strtok($_SERVER['REQUEST_URI'], '?') . ($q ? '?' . http_build_query($q) : '');
    header('Location: ' . $url); exit;
}
$LANG = $_SESSION['lang'] ?? 'ar';
$RTL  = ($LANG === 'ar');
$DIR  = $RTL ? 'rtl' : 'ltr';

$STRINGS = require __DIR__ . '/../lang/strings.php';

/** نص مترجم (يسمح بكيانات HTML مثل &amp;) */
function t($key) {
    global $STRINGS, $LANG;
    if (!isset($STRINGS[$key])) return '[' . $key . ']';
    return $STRINGS[$key][$LANG] ?? $STRINGS[$key]['ar'];
}
function tt($key) { echo t($key); }

/** اختيار نص من مصفوفة ar/en */
function pick($arr) { global $LANG; return $arr[$LANG] ?? $arr['ar']; }

/** هروب آمن */
function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

/** هروب آمن لقيمة داخل خاصية HTML (بدون تكرار ترميز الكيانات) */
function attr($s) { return e(html_entity_decode((string)$s, ENT_QUOTES, 'UTF-8')); }

/** رابط مع الحفاظ على اللغة */
function url($page) { return $page; }

/** رابط تبديل اللغة */
function switch_lang_url() {
    global $LANG;
    $q = $_GET; $q['lang'] = ($LANG === 'ar' ? 'en' : 'ar');
    return strtok($_SERVER['REQUEST_URI'], '?') . '?' . http_build_query($q);
}

/** الصفحة الحالية */
function current_page() { return basename($_SERVER['PHP_SELF']); }
function is_page($p) { return current_page() === $p; }

/** CSRF */
function csrf_token() {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_field() { return '<input type="hidden" name="csrf" value="' . csrf_token() . '">'; }
function csrf_ok() {
    return isset($_POST['csrf'], $_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $_POST['csrf']);
}

/** قائمة الخدمات (للنماذج والصفحات) */
function services_list() {
    $out = [];
    for ($i = 1; $i <= 9; $i++) {
        $out[] = ['key' => 'srv' . $i, 'title' => t('srv' . $i . '_t'), 'desc' => t('srv' . $i . '_d')];
    }
    return $out;
}

/** أيقونات SVG للخدمات */
function service_icon($i) {
    $icons = [
        1 => '<path d="M3 21h18M5 21V8l7-5 7 5v13M9 21v-6h6v6"/>',
        2 => '<path d="M3 21h18M6 21V11h12v10M9 11V7h6v4M10 15h4"/>',
        3 => '<path d="M3 5h18v14H3zM3 10h18M9 5v5M15 10v9"/>',
        4 => '<path d="M4 3h16v18H4zM12 3v18M4 12h16"/>',
        5 => '<path d="M4 20V9l8-5 8 5v11M4 20h16M8 20v-5h8v5M8 12h8"/>',
        6 => '<path d="M3 4h18v16H3zM3 12h18M12 4v16M7 8h2M15 16h2"/>',
        7 => '<path d="M7 3h10v5H7zM12 8v4M9 12h6v9H9z"/>',
        8 => '<path d="M3 17h18M3 17l3-6h12l3 6M7 11V7h10v4M10 21h4"/>',
        9 => '<path d="M3 11l9-7 9 7v9a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/>',
    ];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">' . ($icons[$i] ?? $icons[1]) . '</svg>';
}

/** قائمة الشركاء */
function partners_list() {
    global $LANG;
    $p = [
        ['ar' => 'حسن علام للإنشاءات',            'en' => 'Hassan Allam Construction'],
        ['ar' => 'شركة اتش ايه للإنشاءات',        'en' => 'H.A. Construction'],
        ['ar' => 'معمار المرشدي',                 'en' => 'Memaar Al Morshedy'],
        ['ar' => 'يونيتد إنجينيرنج – UECC',       'en' => 'United Engineering – UECC'],
        ['ar' => 'الخرافي ناشيونال',              'en' => 'Kharafi National'],
        ['ar' => 'شركة يوبتيك',                   'en' => 'Uptec'],
        ['ar' => 'شركة الشمس',                    'en' => 'Al Shams Company'],
        ['ar' => 'شركة طابا العقارية',            'en' => 'Taba Real Estate'],
        ['ar' => 'شركة الرواد',                   'en' => 'Al Rowad Company'],
        ['ar' => 'عمران مصر للتنمية العقارية',    'en' => 'Omran Misr Real Estate'],
        ['ar' => 'الشركة التراثية للتنمية السياحية', 'en' => 'Al Turathia Tourism Dev.'],
        ['ar' => 'كونتيننتال للتنمية السياحية',   'en' => 'Continental Tourism Dev.'],
        ['ar' => 'مراسي ريدكون',                  'en' => 'Marassi Redcon'],
    ];
    return array_map(function ($x) use ($LANG) { return $x[$LANG] ?? $x['ar']; }, $p);
}

/** مجموعات فلترة الاعتمادات حسب الجهة المانحة */
function approval_groups() {
    global $RTL;
    return [
        'all'      => $RTL ? 'كل الاعتمادات'                   : 'All Approvals',
        'ha'       => $RTL ? 'حسن علام للإنشاءات'               : 'Hassan Allam Construction',
        'gov'      => $RTL ? 'الهيئة الهندسية للقوات المسلحة'   : 'Armed Forces Eng. Authority',
        'morshedy' => $RTL ? 'معمار المرشدي'                    : 'Memaar Al Morshedy',
        'mfg'      => $RTL ? 'شهادات المصانع والموردين'          : 'Mill &amp; Supplier Certificates',
    ];
}

/** اعتمادات المواد وشهادات المصانع (الصور في assets/img/approvals) */
function approvals_list() {
    static $list = null;
    if ($list === null) $list = require __DIR__ . '/../lang/approvals.php';
    return $list;
}

/** مشاريع مميزة للعرض في صفحة المشاريع */
function featured_projects() {
    return [
        ['n' => 'Hacienda Bay',   'r' => 'nc', 'ar' => 'أعمال تشطيب ومقاولات، بالإضافة إلى أعمال زجاج وسيكوريت وهاندريل وجبس بورد وسمنت بورد في نطاقات مختلفة من الأعمال.', 'en' => 'Finishing and contracting works, plus glass and securit, handrails, gypsum and cement board across various scopes.'],
        ['n' => 'Hacienda White', 'r' => 'nc', 'ar' => 'أعمال تشطيب متكامل، وأعمال زجاج وسيكوريت وهاندريل ودهانات وGRC.', 'en' => 'Full turnkey finishing, glass and securit works, handrails, painting and GRC.'],
        ['n' => 'Swan Lake',      'r' => 'nc', 'ar' => 'أعمال توريد وتركيب زجاج سيكوريت وهاندريل وشاورات حمامات، بالإضافة إلى أعمال جبس بورد وسمنت بورد.', 'en' => 'Supply and installation of securit glass, handrails and shower enclosures, plus gypsum and cement board.'],
        ['n' => 'Marassi Bay',    'r' => 'nc', 'ar' => 'أعمال جبس بورد وسمنت بورد، بالإضافة إلى أعمال السيكوريت والهاندريل والشاورات والمرايات.', 'en' => 'Gypsum and cement board works, plus securit, handrails, shower enclosures and mirrors.'],
        ['n' => 'Zahra – North Coast', 'r' => 'nc', 'ar' => 'أعمال هاندريل سيكوريت، بالإضافة إلى أعمال سيكوريت ودهانات وجبس بورد وكلادينج وإيبوكسي ضمن نطاقات مختلفة.', 'en' => 'Securit handrails, plus securit, painting, gypsum board, cladding and epoxy across various scopes.'],
        ['n' => 'New Alamein',    'r' => 'nc', 'ar' => 'أعمال جبس بورد ودهانات وكهرباء بمكتب الوزير وقاعة المؤتمرات، وأعمال الفندق بالميناء الحمراء.', 'en' => 'Gypsum board, painting and electrical works at the Minister office and conference hall, plus hotel works at Al Mina Al Hamra.'],
        ['n' => 'Hyde Park',      'r' => 'cc', 'ar' => 'أعمال جبس بورد وسمنت بورد، بالإضافة إلى أعمال معدنية وهاندريل.', 'en' => 'Gypsum and cement board works, plus metal works and handrails.'],
        ['n' => 'Degla Landmark – Madinaty', 'r' => 'cc', 'ar' => 'توريد وتركيب مداخل سيكوريت وهاندريل تربلكس، وأعمال معدنية وهاندريل للسلالم والبلكونات وأعمال دهانات.', 'en' => 'Securit entrances and triplex handrails, metal works and handrails for staircases and balconies, plus painting.'],
        ['n' => 'Degla Towers',   'r' => 'cc', 'ar' => 'أعمال مداخل سيكوريت وهاندريل تربلكس وأعمال معدنية وهاندريل للسلالم والبلكونات وأعمال دهانات.', 'en' => 'Securit entrances, triplex handrails, metal works and handrails for staircases and balconies, plus painting.'],
        ['n' => 'One Kattameya – أرض المشرق', 'r' => 'cc', 'ar' => 'أعمال مداخل وواجهات سيكوريت، هاندريل، أعمال معدنية، جبس بورد وسمنت بورد، كلادينج ولوفر وأعمال أخرى.', 'en' => 'Securit entrances and facades, handrails, metal works, gypsum and cement board, cladding, louvers and more.'],
        ['n' => 'R05 New Capital', 'r' => 'cc', 'ar' => 'توريد وتنفيذ أعمال واجهات سيكوريت.', 'en' => 'Supply and execution of securit facade works.'],
        ['n' => 'Arab African International Bank – New Capital', 'r' => 'cc', 'ar' => 'توريد وتنفيذ أعمال الأسقف الجبسية والبلاطات الجبسية والسمنت بورد.', 'en' => 'Supply and execution of gypsum ceilings, gypsum tiles and cement board.'],
    ];
}
