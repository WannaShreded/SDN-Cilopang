<?php
$html = @file_get_contents('http://sdn-cilopang.test/');
if ($html === false) {
    echo "FETCH_FAIL\n";
    exit(0);
}
$lower = strtolower($html);
if (strpos($lower, 'category/berita') !== false) {
    echo "HAS_BERITA_LINK\n";
} else {
    echo "NO_BERITA_LINK\n";
}
if (strpos($lower, '/agenda/') !== false) {
    echo "HAS_AGENDA_LINK\n";
} else {
    echo "NO_AGENDA_LINK\n";
}
