<?php
// page-agenda.php archived to _archived_templates/page-agenda.php
if (!defined('ABSPATH')) {
    exit;
}

// Defense-in-depth: show 404
status_header(404);
nocache_headers();
include get_query_template('404');
exit;
