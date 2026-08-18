<?php
$urls = [
    '/',
    '/profil-sekolah/',
    '/guru/',
    '/fasilitas/',
    '/ekstrakurikuler/',
    '/kontak/',
];
$base = 'http://sdn-cilopang.test';
foreach ($urls as $u) {
    $url = $base . $u;
    $opts = ['http' => ['method' => 'GET', 'timeout' => 10, 'header' => "User-Agent: PHP-check/1.0\r\n"]];
    $ctx = stream_context_create($opts);
    $html = @file_get_contents($url, false, $ctx);
    $status = "FETCH_FAIL";
    if ($html !== false) {
        // try to extract HTTP response code from $http_response_header
        $status_line = $http_response_header[0] ?? '';
        if (preg_match('#HTTP/\d\.\d\s+(\d{3})#', $status_line, $m)) {
            $status = $m[1];
        } else {
            $status = '200';
        }
    }
    echo "$url -> $status";
    if ($html !== false) {
        $lower = strtolower($html);
        if ($u === '/profil-sekolah/') {
            echo (strpos($lower, 'identity-grid') !== false ? ' | HAS_IDENTITY_GRID' : ' | NO_IDENTITY_GRID');
            // look for section-header and section-title
            echo (strpos($lower, 'section-profile-hero') !== false ? ' | HAS_PROFILE_HERO' : ' | NO_PROFILE_HERO');
            if (preg_match('/<h1[^>]*class="[^"]*section-title[^"]*"[^>]*>(.*?)<\/h1>/is', $html, $m)) {
                echo ' | H1:' . trim(strip_tags($m[1]));
            }
        } else {
            // ensure identity-grid not present on other pages
            echo (strpos($lower, 'identity-grid') !== false ? ' | IDENTITY_GRID_PRESENT' : '');
        }
    }
    echo "\n";
}
