<?php
$archive = @file_get_contents('http://sdn-cilopang.test/fasilitas/');
if ($archive === false) { echo "ARCHIVE_FETCH_FAIL\n"; exit; }
if (preg_match('/<a[^>]+class="[^"]*sdn-fasilitas-link[^"]*"[^>]*href="([^"]+)"/i', $archive, $m)) {
    echo "FOUND:" . $m[1] . "\n";
} else {
    echo "NO_LINK_FOUND\n";
}
