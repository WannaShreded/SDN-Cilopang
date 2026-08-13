<?php

if (!defined('ABSPATH')) {
    exit;
}


/**
 * =========================================================
 * CUSTOM POST TYPE: EKSTRAKURIKULER
 * =========================================================
 */

function sdn_cilopang_register_ekstrakurikuler()
{
    $labels = [
        'name'               => 'Ekstrakurikuler',
        'singular_name'      => 'Ekstrakurikuler',
        'menu_name'          => 'Ekstrakurikuler',
        'add_new'            => 'Tambah Ekstrakurikuler',
        'add_new_item'       => 'Tambah Ekstrakurikuler',
        'edit_item'          => 'Edit Ekstrakurikuler',
        'new_item'           => 'Ekstrakurikuler Baru',
        'view_item'          => 'Lihat Ekstrakurikuler',
        'search_items'       => 'Cari Ekstrakurikuler',
        'not_found'          => 'Ekstrakurikuler tidak ditemukan',
        'not_found_in_trash' => 'Ekstrakurikuler tidak ditemukan di Trash',
    ];

    $args = [
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => 'sdn-cilopang',
        'menu_icon'     => 'dashicons-groups',
        'supports'      => [
            'title',
            'editor',
            'thumbnail',
        ],
        'has_archive'   => true,
        'rewrite'       => [
            'slug' => 'ekstrakurikuler',
        ],
        'show_in_rest'  => true,
    ];

    register_post_type('ekstrakurikuler', $args);
}

add_action(
    'init',
    'sdn_cilopang_register_ekstrakurikuler'
);


/**
 * =========================================================
 * META BOX EKSTRAKURIKULER
 * =========================================================
 */

function sdn_cilopang_ekstrakurikuler_metabox()
{
    add_meta_box(
        'sdn_ekstrakurikuler_data',
        'Informasi Ekstrakurikuler',
        'sdn_cilopang_ekstrakurikuler_metabox_html',
        'ekstrakurikuler',
        'normal',
        'high'
    );
}

add_action(
    'add_meta_boxes',
    'sdn_cilopang_ekstrakurikuler_metabox'
);


/**
 * Tampilan Meta Box
 */

function sdn_cilopang_ekstrakurikuler_metabox_html($post)
{
    wp_nonce_field(
        'sdn_cilopang_simpan_ekstrakurikuler',
        'sdn_cilopang_ekstrakurikuler_nonce'
    );

    $pembina = get_post_meta(
        $post->ID,
        '_sdn_pembina',
        true
    );

    $jadwal = get_post_meta(
        $post->ID,
        '_sdn_jadwal',
        true
    );

    $tempat = get_post_meta(
        $post->ID,
        '_sdn_tempat',
        true
    );
    ?>

    <p>
        <label for="sdn_pembina">
            <strong>Pembina</strong>
        </label>

        <input
            type="text"
            id="sdn_pembina"
            name="sdn_pembina"
            value="<?php echo esc_attr($pembina); ?>"
            class="widefat"
            placeholder="Contoh: Budi Santoso, S.Pd."
        >
    </p>

    <p>
        <label for="sdn_jadwal">
            <strong>Jadwal</strong>
        </label>

        <input
            type="text"
            id="sdn_jadwal"
            name="sdn_jadwal"
            value="<?php echo esc_attr($jadwal); ?>"
            class="widefat"
            placeholder="Contoh: Jumat, 14.00 - 16.00"
        >
    </p>

    <p>
        <label for="sdn_tempat">
            <strong>Tempat</strong>
        </label>

        <input
            type="text"
            id="sdn_tempat"
            name="sdn_tempat"
            value="<?php echo esc_attr($tempat); ?>"
            class="widefat"
            placeholder="Contoh: Lapangan Sekolah"
        >
    </p>

    <?php
}


/**
 * =========================================================
 * SIMPAN DATA EKSTRAKURIKULER
 * =========================================================
 */

function sdn_cilopang_simpan_ekstrakurikuler($post_id)
{
    if (
        !isset($_POST['sdn_cilopang_ekstrakurikuler_nonce']) ||
        !wp_verify_nonce(
            $_POST['sdn_cilopang_ekstrakurikuler_nonce'],
            'sdn_cilopang_simpan_ekstrakurikuler'
        )
    ) {
        return;
    }

    if (
        defined('DOING_AUTOSAVE') &&
        DOING_AUTOSAVE
    ) {
        return;
    }

    if (
        !current_user_can('edit_post', $post_id)
    ) {
        return;
    }

    if (
        get_post_type($post_id) !== 'ekstrakurikuler'
    ) {
        return;
    }

    $fields = [
        'sdn_pembina',
        'sdn_jadwal',
        'sdn_tempat',
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta(
                $post_id,
                '_' . $field,
                sanitize_text_field($_POST[$field])
            );
        }
    }
}

add_action(
    'save_post_ekstrakurikuler',
    'sdn_cilopang_simpan_ekstrakurikuler'
);


/**
 * =========================================================
 * SHORTCODE: DAFTAR EKSTRAKURIKULER
 * =========================================================
 */

function sdn_cilopang_daftar_ekstrakurikuler()
{
    $query = new WP_Query([
        'post_type'      => 'ekstrakurikuler',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]);

    if (!$query->have_posts()) {
        return '<p>Belum ada data ekstrakurikuler.</p>';
    }

    ob_start();
    ?>

    <div class="sdn-ekstrakurikuler-grid">

        <?php while ($query->have_posts()) : $query->the_post(); ?>

            <?php
            $pembina = get_post_meta(
                get_the_ID(),
                '_sdn_pembina',
                true
            );

            $jadwal = get_post_meta(
                get_the_ID(),
                '_sdn_jadwal',
                true
            );

            $tempat = get_post_meta(
                get_the_ID(),
                '_sdn_tempat',
                true
            );
            ?>

            <article class="sdn-ekstrakurikuler-card">

                <div class="sdn-ekstrakurikuler-photo">

                    <?php if (has_post_thumbnail()) : ?>

                        <?php the_post_thumbnail('large'); ?>

                    <?php else : ?>

                        <div class="sdn-ekstrakurikuler-no-photo">
                            Tidak ada foto
                        </div>

                    <?php endif; ?>

                </div>

                <div class="sdn-ekstrakurikuler-content">

                    <h3>
                        <?php the_title(); ?>
                    </h3>

                    <?php if ($pembina) : ?>

                        <p>
                            <strong>Pembina:</strong>
                            <?php echo esc_html($pembina); ?>
                        </p>

                    <?php endif; ?>

                    <?php if ($jadwal) : ?>

                        <p>
                            <strong>Jadwal:</strong>
                            <?php echo esc_html($jadwal); ?>
                        </p>

                    <?php endif; ?>

                    <?php if ($tempat) : ?>

                        <p>
                            <strong>Tempat:</strong>
                            <?php echo esc_html($tempat); ?>
                        </p>

                    <?php endif; ?>

                    <?php if (get_the_content()) : ?>

                        <div class="sdn-ekstrakurikuler-description">
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
    'sdn_daftar_ekstrakurikuler',
    'sdn_cilopang_daftar_ekstrakurikuler'
);