<?php
// This agenda archive template has been archived on 2026-08-15 as part of Fase 16 cleanup.
// The original content has been moved to _archived_templates/archive-agenda.php

// Ensure a 404 if this template is directly reached (defense-in-depth)
if (!defined('ABSPATH')) {
    exit;
}

status_header(404);
nocache_headers();
include get_query_template('404');
exit;
