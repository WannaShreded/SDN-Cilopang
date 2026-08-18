<?php
$html = @file_get_contents('http://sdn-cilopang.test/');
if ($html === false) { echo "FETCH_FAIL\n"; exit; }
$lower = strtolower($html);
echo (strpos($lower,'sdn-ekstrakurikuler-description')!==false ? 'HOME_HAS_DESC' : 'HOME_NO_DESC') . "\n";
