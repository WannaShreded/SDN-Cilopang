<?php
$pages = ['/', '/profil-sekolah/', '/guru/', '/fasilitas/', '/ekstrakurikuler/', '/kontak/'];
$base = 'http://sdn-cilopang.test';
foreach ($pages as $p) {
    $u = $base . $p;
    $h = @file_get_contents($u);
    $s = $h === false ? 'FETCH_FAIL' : '200';
    echo "$u -> $s\n";
}
