<?php

if (!defined('ABSPATH')) {
    exit;
}


/**
 * =========================================================
 * CUSTOM POST TYPE: FASILITAS
 * =========================================================
 */

function sdn_cilopang_register_fasilitas()
{
    $labels = [
        'name'               => 'Fasilitas Sekolah',
        'singular_name'      => 'Fasilitas Sekolah',
        'menu_name'          => 'Fasilitas Sekolah',
        'add_new'            => 'Tambah Fasilitas',
        'add_new_item'       => 'Tambah Fasilitas',
        'edit_item'          => 'Edit Fasilitas',
        'new_item'           => 'Fasilitas Baru',
        'view_item'          => 'Lihat Fasilitas',
        'search_items'       => 'Cari Fasilitas',
        'not_found'          => 'Fasilitas tidak ditemukan',
        'not_found_in_trash' => 'Fasilitas tidak ditemukan di Trash',
    ];

    $args = [
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => 'sdn-cilopang',
        'menu_icon'     => 'dashicons-building',
        'supports'      => [
            'title',
            'editor',
            'thumbnail',
        ],
        'has_archive'   => true,
        'rewrite'       => [
            'slug' => 'fasilitas',
        ],
        'show_in_rest'  => false,
    ];

    register_post_type('fasilitas', $args);
}

add_action(
    'init',
    'sdn_cilopang_register_fasilitas'
);

function sdn_cilopang_fasilitas_title_placeholder($title)
{
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'fasilitas') {
        return $title;
    }

    return 'Nama Fasilitas';
}

add_filter('enter_title_here', 'sdn_cilopang_fasilitas_title_placeholder');

function sdn_cilopang_fasilitas_featured_image_label($content)
{
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'fasilitas') {
        return $content;
    }

    $content = str_replace('Featured image', 'Foto Fasilitas', $content);
    $content .= '<p class="description">Gunakan foto yang jelas agar fasilitas tampil baik di website.</p>';

    return $content;
}

add_filter('admin_post_thumbnail_html', 'sdn_cilopang_fasilitas_featured_image_label');

function sdn_cilopang_fasilitas_admin_styles($hook)
{
    if (!in_array($hook, ['post.php', 'post-new.php'], true)) {
        return;
    }

    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'fasilitas') {
        return;
    }

    $css = "
        .post-type-fasilitas #postimagediv > h2 span {
            font-size: 13px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }
        .post-type-fasilitas .sdn-school-admin-shell {
            margin-top: 12px;
        }
        .post-type-fasilitas .sdn-school-admin-section {
            margin: 18px 0 12px;
            padding: 14px 16px;
            border: 1px solid #dfe7f1;
            border-radius: 10px;
            background: #f8fafc;
        }
        .post-type-fasilitas .sdn-school-admin-section h3 {
            margin: 0 0 12px;
            font-size: 13px;
            line-height: 1.4;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #1d4ed8;
        }
        .post-type-fasilitas .sdn-school-admin-label,
        .post-type-fasilitas .sdn-school-admin-help {
            display: block;
            color: #172033;
            font-weight: 600;
            margin: 0 0 8px;
        }
        .post-type-fasilitas .sdn-school-admin-help {
            font-weight: 400;
            color: #64748b;
            font-size: 12px;
            line-height: 1.5;
        }
    ";

    wp_add_inline_style('wp-admin', $css);
}

add_action('admin_enqueue_scripts', 'sdn_cilopang_fasilitas_admin_styles');

function sdn_cilopang_fasilitas_metabox()
{
    add_meta_box(
        'sdn_fasilitas_data',
        'Data Fasilitas',
        'sdn_cilopang_fasilitas_metabox_html',
        'fasilitas',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sdn_cilopang_fasilitas_metabox');

function sdn_cilopang_fasilitas_metabox_html($post)
{
    ?>
    <div class="sdn-school-admin-shell">
        <div class="sdn-school-admin-section">
            <h3>Data Fasilitas</h3>
            <div class="sdn-school-admin-label">Foto Fasilitas</div>
            <div class="sdn-school-admin-help">Foto Fasilitas dapat dipilih melalui panel Gambar Unggulan di sebelah kanan. Gunakan foto yang jelas agar fasilitas tampil baik di website.</div>
        </div>
    </div>
    <?php
}

/**
 * =========================================================
 * SHORTCODE: DAFTAR FASILITAS
 * =========================================================
 */

function sdn_cilopang_daftar_fasilitas()
{
    $query = new WP_Query([
        'post_type'      => 'fasilitas',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]);

    if (!$query->have_posts()) {
        return '<p>Belum ada data fasilitas.</p>';
    }

    ob_start();
    ?>

    <div class="sdn-fasilitas-grid">

        <?php while ($query->have_posts()) : $query->the_post(); ?>

            <article class="sdn-fasilitas-card">

                <div class="sdn-fasilitas-photo">

                    <?php if (has_post_thumbnail()) : ?>

                        <?php the_post_thumbnail('large'); ?>

                    <?php else : ?>

                        <div class="sdn-fasilitas-no-photo">
                            Tidak ada foto
                        </div>

                    <?php endif; ?>

                </div>

                <div class="sdn-fasilitas-content">

                    <h3>
                        <?php the_title(); ?>
                    </h3>

                    <?php if (get_the_content()) : ?>

                        <div class="sdn-fasilitas-description">
                            <?php the_content(); ?>
                        </div>

                    <?php endif; ?>

                </div>

            </article>

        <?php endwhile; ?>

    </div>

    <?php

    wp_reset_postdata();

    return ob_get_clean();
}

add_shortcode(
    'sdn_daftar_fasilitas',
    'sdn_cilopang_daftar_fasilitas'
);