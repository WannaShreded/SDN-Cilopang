<?php
$routes = [
    '/' => '/',
    '/profil-sekolah/' => '/profil-sekolah/',
    '/kontak/' => '/kontak/',
    '/agenda/' => '/agenda/',
    '/agenda/karnaval-kemerdekaan/' => '/agenda/karnaval-kemerdekaan/',
    '/fasilitas/' => '/fasilitas/',
    '/fasilitas/lapangan-sekolah/' => '/fasilitas/lapangan-sekolah/',
    '/ekstrakurikuler/' => '/ekstrakurikuler/',
    '/ekstrakurikuler/pramuka/' => '/ekstrakurikuler/pramuka/',
    '/guru/' => '/guru/',
    '/guru/arini/' => '/guru/arini/',
];

function fetch($url) {
    $ctx = stream_context_create(['http'=>['ignore_errors'=>true]]);
    $html = @file_get_contents($url,false,$ctx);
    $status = 0;
    if (isset($http_response_header)) {
        foreach ($http_response_header as $h) {
            if (preg_match('#HTTP/\d+\.\d+\s+(\d+)#',$h,$m)) { $status=(int)$m[1]; break; }
        }
    }
    return [$status,$html];
}

foreach ($routes as $label => $path) {
    $url = 'http://sdn-cilopang.test' . $path;
    list($status,$html) = fetch($url);
    echo "\n=== PAGE: {$url} (HTTP={$status}) ===\n";
    if ($html === false) { echo "FETCH_FAIL\n"; continue; }

    // Basic checks using simpler substring searches to avoid complex regex parsing
    $checks = [];
    $lower = strtolower($html);
    $checks['has_meta_viewport'] = (stripos($html,'name="viewport"') !== false || stripos($html,"name='viewport'") !== false) ? 'YES' : 'NO';
    $checks['has_site_logo_img'] = (stripos($lower,'class="site-logo"') !== false || stripos($lower,'class=\'site-logo\'') !== false || stripos($lower,'site-logo') !== false) && (stripos($lower,'<img') !== false) ? 'YES' : 'NO';
    $checks['has_site_logo'] = stripos($lower,'site-logo') !== false ? 'YES' : 'NO';
    $checks['has_nav_menu'] = stripos($lower,'main-navigation') !== false ? 'YES' : 'NO';
    $checks['has_nav_toggle'] = stripos($lower,'nav-toggle') !== false ? 'YES' : 'NO';
    $checks['has_hero'] = stripos($lower,' class="hero"') !== false || stripos($lower,' class=\'hero\'') !== false || stripos($lower,' hero-') !== false || stripos($lower,'-hero') !== false ? 'YES' : 'NO';
    $checks['has_section_hero'] = stripos($lower,'-hero') !== false ? 'YES' : 'NO';
    $checks['has_footer'] = stripos($lower,'site-footer') !== false ? 'YES' : 'NO';
    $checks['has_footer_grid'] = stripos($lower,'footer-grid') !== false ? 'YES' : 'NO';
    $checks['has_btn'] = stripos($lower,' class="btn"') !== false || stripos($lower,'btn ') !== false || stripos($lower,'btn>') !== false ? 'YES' : 'NO';
    $checks['has_btn_primary'] = stripos($lower,'btn-primary') !== false ? 'YES' : 'NO';
    $checks['has_cards'] = (stripos($lower,'sdn-guru-card') !== false || stripos($lower,'sdn-agenda-card') !== false || stripos($lower,'sdn-fasilitas') !== false || stripos($lower,'sdn-ekstrakurikuler') !== false) ? 'YES' : 'NO';
    $checks['has_iframe'] = stripos($lower,'<iframe') !== false ? 'YES' : 'NO';
    $checks['has_contact_grid'] = stripos($lower,'contact-grid') !== false ? 'YES' : 'NO';
    // detect presence of a back link with btn and btn-primary classes and the text 'Kembali'
    $checks['single_has_back_btn_primary'] = (stripos($lower,'btn') !== false && stripos($lower,'btn-primary') !== false && stripos($lower,'kembali') !== false) ? 'YES' : 'NO';

    // Count images
    preg_match_all('/<img\b[^>]*>/i',$html,$imgs);
    $checks['img_count'] = count($imgs[0]);

    foreach ($checks as $k => $v) {
        echo "$k: $v\n";
    }

    // Quick specific issues heuristics
    // Long unbroken strings > 60 chars
    if (preg_match('/[A-Za-z0-9]{60,}/',$html,$m)) {
        echo "POTENTIAL_LONG_UNBROKEN_STRING: yes\n";
    }

    // Inline style blocks presence
    preg_match_all('/<style[^>]*>[\s\S]*?<\/style>/i',$html,$styles);
    echo "INLINE_STYLE_BLOCKS=".count($styles[0])."\n";

}
