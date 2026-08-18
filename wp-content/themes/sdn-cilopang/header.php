<?php

if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option(
    'sdn_cilopang_settings',
    []
);

$nama_sekolah = $settings['nama_sekolah']
    ?? 'SDN Cilopang';

$tagline = $settings['tagline']
    ?? 'Sekolah Dasar Negeri Cilopang';

$logo = !empty($settings['logo'])
    ? wp_get_attachment_image_url(
        $settings['logo'],
        'medium'
    )
    : '';

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

    <meta charset="<?php bloginfo('charset'); ?>">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<header class="site-header">

    <div class="container header-inner">

        <a
            href="<?php echo esc_url(home_url('/')); ?>"
            class="site-logo"
        >

            <?php if ($logo) : ?>

                <img
                    src="<?php echo esc_url($logo); ?>"
                    alt="<?php echo esc_attr($nama_sekolah); ?>"
                >

            <?php endif; ?>

            <div class="site-logo-text">

                <strong>
                    <?php echo esc_html($nama_sekolah); ?>
                </strong>

                <span>
                    <?php echo esc_html($tagline); ?>
                </span>

            </div>

        </a>


        <button
            class="nav-toggle"
            type="button"
            aria-expanded="false"
            aria-controls="primary-navigation"
        >
            <span class="nav-toggle__bar"></span>
            <span class="nav-toggle__bar"></span>
            <span class="nav-toggle__bar"></span>
            <span class="screen-reader-text">Menu</span>
        </button>
        
        <div class="nav-overlay" id="nav-overlay"></div>

        <nav
            id="primary-navigation"
            class="main-navigation"
            aria-label="Menu Utama"
        >
            <button type="button" class="nav-drawer-close" aria-label="Tutup menu">
                &times;
            </button>

            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'fallback_cb'    => false,
            ]);
            ?>

        </nav>

    </div>

</header>