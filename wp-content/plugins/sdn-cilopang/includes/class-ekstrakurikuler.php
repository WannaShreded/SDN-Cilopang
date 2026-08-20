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
        'show_in_rest'  => false,
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
    'sdn_cilopang_ekstrakurikuler_metabox',
    10
);


function sdn_cilopang_ekstrakurikuler_title_placeholder($title)
{
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'ekstrakurikuler') {
        return $title;
    }

    return 'Nama Ekstrakurikuler';
}

add_filter('enter_title_here', 'sdn_cilopang_ekstrakurikuler_title_placeholder');

function sdn_cilopang_ekstrakurikuler_featured_image_label($content)
{
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'ekstrakurikuler') {
        return $content;
    }

    $content = str_replace('Featured image', 'Foto Ekstrakurikuler', $content);
    $content .= '<p class="description">Gunakan foto yang jelas agar kegiatan tampil lebih menarik di website.</p>';

    return $content;
}

add_filter('admin_post_thumbnail_html', 'sdn_cilopang_ekstrakurikuler_featured_image_label');


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

    <div class="sdn-school-admin-shell">
        <div class="sdn-school-admin-section">
            <h3>Informasi Ekstrakurikuler</h3>
            <div class="sdn-school-admin-field">
                <span class="sdn-school-admin-help">Foto Ekstrakurikuler dapat dipilih melalui panel Gambar Unggulan di sebelah kanan.</span>
            </div>
            <div class="sdn-school-admin-grid">
                <div class="sdn-school-admin-field">
                    <label for="sdn_pembina">Pembina</label>
                    <input
                        type="text"
                        id="sdn_pembina"
                        name="sdn_pembina"
                        value="<?php echo esc_attr($pembina); ?>"
                        class="widefat"
                        placeholder="Nama Pembina Ekstrakurikuler"
                    >
                </div>

                <div class="sdn-school-admin-field">
                    <label for="sdn_jadwal">Jadwal</label>
                    <input
                        type="text"
                        id="sdn_jadwal"
                        name="sdn_jadwal"
                        value="<?php echo esc_attr($jadwal); ?>"
                        class="widefat"
                        placeholder="Contoh: Jumat, 14.00 - 16.00"
                    >
                </div>

                <div class="sdn-school-admin-field">
                    <label for="sdn_tempat">Tempat</label>
                    <input
                        type="text"
                        id="sdn_tempat"
                        name="sdn_tempat"
                        value="<?php echo esc_attr($tempat); ?>"
                        class="widefat"
                        placeholder="Contoh: Lapangan Sekolah"
                    >
                </div>
            </div>
        </div>

        <div class="sdn-school-admin-section">
            <h3>Deskripsi Ekstrakurikuler</h3>
            <div class="sdn-school-admin-field">
                <span class="sdn-school-admin-label">Editor Deskripsi</span>
                <span class="sdn-school-admin-help">Tambahkan penjelasan singkat agar kegiatan mudah dipahami masyarakat sekolah.</span>
            </div>
        </div>
    </div>

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

            <article class="card sdn-ekstrakurikuler-card">

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

                    <?php if ($pembina || $jadwal || $tempat) : ?>

                        <div class="sdn-ekstrakurikuler-meta">

                            <?php if ($pembina) : ?>
                                <div class="sdn-ekstrakurikuler-meta-item">
                                    <span class="sdn-ekstrakurikuler-meta-label">Pembina</span>
                                    <span class="sdn-ekstrakurikuler-meta-value"><?php echo esc_html($pembina); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($jadwal) : ?>
                                <div class="sdn-ekstrakurikuler-meta-item">
                                    <span class="sdn-ekstrakurikuler-meta-label">Jadwal</span>
                                    <span class="sdn-ekstrakurikuler-meta-value"><?php echo esc_html($jadwal); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($tempat) : ?>
                                <div class="sdn-ekstrakurikuler-meta-item">
                                    <span class="sdn-ekstrakurikuler-meta-label">Tempat</span>
                                    <span class="sdn-ekstrakurikuler-meta-value"><?php echo esc_html($tempat); ?></span>
                                </div>
                            <?php endif; ?>

                        </div>

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