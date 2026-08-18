<?php
$html = @file_get_contents('http://sdn-cilopang.test/profil-sekolah/');
if ($html === false) {
    echo "FETCH_FAIL\n";
    exit(0);
}
$lower = strtolower($html);
echo (strpos($lower, 'identity-grid') !== false ? 'HAS_IDENTITY_GRID' : 'NO_IDENTITY_GRID') . "\n";
echo (strpos($lower, 'section-profile-hero') !== false ? 'HAS_PROFILE_HERO' : 'NO_PROFILE_HERO') . "\n";
// output title snippet
if (preg_match('/<h1[^>]*class="[^"]*section-title[^"]*"[^>]*>(.*?)<\/h1>/is', $html, $m)) {
    echo "TITLE:" . trim(strip_tags($m[1])) . "\n";
} else {
    echo "NO_H1\n";
}
