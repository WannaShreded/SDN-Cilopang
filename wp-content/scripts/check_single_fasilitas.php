<?php
$html = @file_get_contents('http://sdn-cilopang.test/fasilitas/lapangan-sekolah/');
if ($html === false) { echo "FETCH_FAIL\n"; exit; }
$lower = strtolower($html);
echo (strpos($lower,'sdn-fasilitas-single-photo')!==false ? 'SINGLE_PHOTO_PRESENT' : 'NO_SINGLE_PHOTO') . "\n";
if (preg_match('/<h1[^>]*class="[^"]*section-title[^"]*"[^>]*>(.*?)<\/h1>/is', $html, $m)) {
    echo 'H1:' . trim(strip_tags($m[1])) . "\n";
}
