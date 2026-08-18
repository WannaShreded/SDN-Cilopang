<?php
$urls = [
    '/',
    '/ekstrakurikuler/',
    '/ekstrakurikuler/pramuka/',
    '/fasilitas/',
    '/profil-sekolah/',
    '/guru/',
    '/kontak/',
];
$base = 'http://sdn-cilopang.test';
foreach ($urls as $u) {
    $url = $base . $u;
    $html = @file_get_contents($url);
    $status = ($html === false) ? 'FETCH_FAIL' : '200';
    echo "$url -> $status";
    if ($html !== false) {
        $lower = strtolower($html);
        if (strpos($lower,'sdn-ekstrakurikuler-grid')!==false) echo ' | HAS_EKSKUL_GRID';
        if (strpos($lower,'sdn-ekstrakurikuler-card')!==false) echo ' | HAS_EKSKUL_CARD';
        if (strpos($lower,'sdn-ekstrakurikuler-single-photo')!==false) echo ' | HAS_EKSKUL_SINGLE_PHOTO';
    }
    echo "\n";
}
