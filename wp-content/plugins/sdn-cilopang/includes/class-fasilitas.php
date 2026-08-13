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
        'name'               => 'Fasilitas',
        'singular_name'      => 'Fasilitas',
        'menu_name'          => 'Fasilitas',
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
        'show_in_rest'  => true,
    ];

    register_post_type('fasilitas', $args);
}

add_action(
    'init',
    'sdn_cilopang_register_fasilitas'
);


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