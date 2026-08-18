<?php

if (!defined('ABSPATH')) {
    exit;
}

function sdn_cilopang_custom_body_classes($classes)
{
    if (is_page('profil-sekolah')) {
        $classes[] = 'page-profil-sekolah';
    }

    if (is_page('kontak')) {
        $classes[] = 'page-kontak';
    }

    return $classes;
}

add_filter('body_class', 'sdn_cilopang_custom_body_classes');

/**
 * Theme Setup
 */
function sdn_cilopang_theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menus([
        'primary' => 'Menu Utama',
    ]);
}

add_action(
    'after_setup_theme',
    'sdn_cilopang_theme_setup'
);


/**
 * Load Theme CSS
 */
function sdn_cilopang_theme_enqueue_styles()
{
    wp_enqueue_style(
        'sdn-cilopang-theme-style',
        get_stylesheet_uri(),
        [],
        filemtime(
            get_template_directory() . '/style.css'
        )
    );
}

add_action(
    'wp_enqueue_scripts',
    'sdn_cilopang_theme_enqueue_styles'
);

function sdn_cilopang_theme_enqueue_scripts()
{
    wp_enqueue_script(
        'sdn-cilopang-navigation',
        get_template_directory_uri() . '/js/navigation.js',
        [],
        filemtime(
            get_template_directory() . '/js/navigation.js'
        ),
        true
    );

    // Scroll reveal: fade-in-up for sections on scroll (vanilla JS)
    wp_enqueue_script(
        'sdn-cilopang-scroll-reveal',
        get_template_directory_uri() . '/js/scroll-reveal.js',
        [],
        filemtime(
            get_template_directory() . '/js/scroll-reveal.js'
        ),
        true
    );

    wp_enqueue_script(
        'sdn-cilopang-image-reveal',
        get_template_directory_uri() . '/js/image-reveal.js',
        [],
        filemtime(
            get_template_directory() . '/js/image-reveal.js'
        ),
        true
    );

    wp_enqueue_script(
        'sdn-cilopang-card-spotlight',
        get_template_directory_uri() . '/js/card-spotlight.js',
        [],
        filemtime(
            get_template_directory() . '/js/card-spotlight.js'
        ),
        true
    );

    wp_enqueue_script(
        'sdn-cilopang-stat-counter',
        get_template_directory_uri() . '/js/stat-counter.js',
        [],
        filemtime(
            get_template_directory() . '/js/stat-counter.js'
        ),
        true
    );
}

add_action(
    'wp_enqueue_scripts',
    'sdn_cilopang_theme_enqueue_scripts'
);

function sdn_cilopang_hide_frontend_admin_bar_for_non_admin()
{
    if (is_user_logged_in() && !current_user_can('manage_options')) {
        show_admin_bar(false);
    }
}

add_action('after_setup_theme', 'sdn_cilopang_hide_frontend_admin_bar_for_non_admin');