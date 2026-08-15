<?php
// count_berita.php — reports published posts and category counts for 'berita' and 'pengumuman'
// Usage: php count_berita.php

$root = realpath(__DIR__ . '/../../');
if (!$root) {
    $root = __DIR__ . '/..';
}
require_once $root . '/wp-load.php';

// Count published posts
$published = wp_count_posts('post');
$published_count = $published->publish ?? 0;

// Count terms in category taxonomy for 'berita' and 'pengumuman'
$berita_term = get_term_by('slug', 'berita', 'category');
$pengumuman_term = get_term_by('slug', 'pengumuman', 'category');

$berita_count = $berita_term ? $berita_term->count : 0;
$pengumuman_count = $pengumuman_term ? $pengumuman_term->count : 0;

echo "published_posts={$published_count}\n";
echo "category_berita_count={$berita_count}\n";
echo "category_pengumuman_count={$pengumuman_count}\n";

// Sample published post (if any)
$sample = get_posts(['post_status' => 'publish', 'posts_per_page' => 1]);
if (!empty($sample)) {
    $p = $sample[0];
    echo "sample_post_slug=" . $p->post_name . "\n";
    echo "sample_post_url=" . get_permalink($p->ID) . "\n";
} else {
    echo "sample_post_slug=\n";
    echo "sample_post_url=\n";
}
