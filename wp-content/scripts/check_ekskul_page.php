<?php
$html = @file_get_contents('http://sdn-cilopang.test/ekstrakurikuler/');
if ($html === false) { echo "FETCH_FAIL\n"; exit; }
$lower = strtolower($html);
echo (strpos($lower,'sdn-ekstrakurikuler-grid')!==false ? 'HAS_GRID' : 'NO_GRID') . "\n";
echo (strpos($lower,'sdn-ekstrakurikuler-card')!==false ? 'HAS_CARDS' : 'NO_CARDS') . "\n";
echo (strpos($lower,'sdn-ekstrakurikuler-description')!==false ? 'HAS_DESC' : 'NO_DESC') . "\n";
if (preg_match('/<h1[^>]*class="[^"]*section-title[^"]*"[^>]*>(.*?)<\/h1>/is', $html, $m)) {
    echo 'H1:' . trim(strip_tags($m[1])) . "\n";
}
