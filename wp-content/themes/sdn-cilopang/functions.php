<?php

if (!defined('ABSPATH')) {
    exit;
}


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
}

add_action(
    'wp_enqueue_scripts',
    'sdn_cilopang_theme_enqueue_scripts'
);