<?php
$url = 'http://sdn-cilopang.test/wp-admin/edit.php?post_type=agenda';
$ctx = stream_context_create(['http' => ['ignore_errors' => true]]);
$html = @file_get_contents($url, false, $ctx);
$status = 0;
if (isset($http_response_header)) {
    foreach ($http_response_header as $h) {
        if (preg_match('#HTTP/\d+\.\d+\s+(\d+)#', $h, $m)) {
            $status = (int) $m[1];
            break;
        }
    }
}
echo "URL={$url} STATUS={$status}\n";
if ($html !== false) {
    $len = strlen($html);
    echo "LENGTH={$len}\n";
    if (preg_match('/Agenda/i', $html)) {
        echo "BODY_CONTAINS_AGENDA=YES\n";
    } else {
        echo "BODY_CONTAINS_AGENDA=NO\n";
    }
}
