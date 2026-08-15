<?php
$paths = [
    '/' => '/',
    '/kontak/' => '/kontak/',
    '/guru/' => '/guru/',
    '/agenda/' => '/agenda/',
    '/fasilitas/' => '/fasilitas/',
    '/ekstrakurikuler/' => '/ekstrakurikuler/',
    '/profil-sekolah/' => '/profil-sekolah/',
    '/category/berita/' => '/category/berita/',
    '/category/pengumuman/' => '/category/pengumuman/',
    '/sman-1-majalaya-resmi-buka-mpls/' => '/sman-1-majalaya-resmi-buka-mpls/',
];
foreach ($paths as $label => $path) {
    $url = 'http://sdn-cilopang.test' . $path;
    $ctx = stream_context_create(['http' => ['ignore_errors' => true]]);
    $html = @file_get_contents($url, false, $ctx);
    $status = 0;
    if (isset($http_response_header)) {
        foreach ($http_response_header as $h) {
            if (preg_match('#HTTP/\d+\.\d+\s+(\d+)#', $h, $m)) { $status = (int)$m[1]; break; }
        }
    }
    $errors = 'NO';
    if ($html !== false && preg_match('/Warning:|Notice:|Fatal error|Parse error/i', $html)) { $errors = 'YES'; }
    $has_inline_style = ($html !== false && strpos($html, '<style') !== false) ? 'YES' : 'NO';
    echo strtoupper(trim($label)) . " URL={$url} STATUS={$status} ERRORS={$errors} HAS_INLINE_STYLE={$has_inline_style}\n";
}
