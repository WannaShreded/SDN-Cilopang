<?php
$url = 'http://sdn-cilopang.test/kontak/';
$ctx = stream_context_create(['http'=>['ignore_errors'=>true]]);
$html = @file_get_contents($url,false,$ctx);
if ($html===false) { echo "FETCH_FAIL\n"; exit(1); }
$marker = strpos($html, '<!-- Contact page styles moved to style.css -->') !== false ? 'MARKER_FOUND' : 'MARKER_MISSING';
$style_count = preg_match_all('/<style[^>]*>/i', $html, $m);
echo "STATUS_OK HTML_LEN=".strlen($html)." STYLE_TAGS=".$style_count." " . $marker . "\n";
$pos = strpos($html, '<style');
if ($pos !== false) {
    echo "FIRST_STYLE_SNIPPET:\n" . substr($html, max(0,$pos-100), 300) . "\n";
}
