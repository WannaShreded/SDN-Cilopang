<?php
$urls = [
    '/fasilitas/',
    // find a sample fasilitas slug by reading the archive page and extracting the first link
];
$base = 'http://sdn-cilopang.test';
// fetch archive to find sample slug
$archive = @file_get_contents($base . '/fasilitas/');
if ($archive !== false && preg_match('#href="([^"]+/fasilitas/[^"]+)"#i', $archive, $m)) {
    $sample = $m[1];
    $urls[] = $sample;
}
foreach ($urls as $u) {
    $url = (strpos($u, 'http') === 0) ? $u : $base . $u;
    $html = @file_get_contents($url);
    $status = ($html === false) ? 'FETCH_FAIL' : '200';
    echo "$url -> $status";
    if ($html !== false) {
        $lower = strtolower($html);
        if (strpos($lower, 'sdn-fasilitas-grid') !== false) echo ' | HAS_GRID';
        if (strpos($lower, 'sdn-fasilitas-card') !== false) echo ' | HAS_CARDS';
        if (strpos($lower, 'sdn-fasilitas-single-photo') !== false) echo ' | SINGLE_PHOTO';
    }
    echo "\n";
}
