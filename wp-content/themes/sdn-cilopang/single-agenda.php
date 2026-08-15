<?php
// single-agenda.php has been archived (moved to _archived_templates/single-agenda.php)
// Defense-in-depth: return 404 if reached directly
if (!defined('ABSPATH')) {
    exit;
}

status_header(404);
nocache_headers();
include get_query_template('404');
exit;
