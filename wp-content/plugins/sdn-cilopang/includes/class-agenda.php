<?php

if (!defined('ABSPATH')) {
    exit;
}


/**
 * =========================================================
 * CUSTOM POST TYPE: AGENDA
 * =========================================================
 */

function sdn_cilopang_register_agenda()
{
    $labels = [
        'name'               => 'Agenda',
        'singular_name'      => 'Agenda',
        'menu_name'          => 'Agenda Sekolah',
        'add_new'            => 'Tambah Agenda',
        'add_new_item'       => 'Tambah Agenda',
        'edit_item'          => 'Edit Agenda',
        'new_item'           => 'Agenda Baru',
        'view_item'          => 'Lihat Agenda',
        'search_items'       => 'Cari Agenda',
        'not_found'          => 'Agenda tidak ditemukan',
        'not_found_in_trash' => 'Agenda tidak ditemukan di Trash',
    ];

    $args = [
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => 'sdn-cilopang',
        'menu_icon'     => 'dashicons-calendar-alt',
        'supports'      => [
            'title',
            'editor',
            'thumbnail',
        ],
        'has_archive'  => true,
        'rewrite'      => [
            'slug' => 'agenda',
        ],
        'show_in_rest' => true,
    ];

    register_post_type('agenda', $args);
}

add_action(
    'init',
    'sdn_cilopang_register_agenda'
);


/**
 * =========================================================
 * META BOX AGENDA
 * =========================================================
 */

function sdn_cilopang_agenda_metabox()
{
    add_meta_box(
        'sdn_agenda_data',
        'Informasi Agenda',
        'sdn_cilopang_agenda_metabox_html',
        'agenda',
        'normal',
        'high'
    );
}

add_action(
    'add_meta_boxes',
    'sdn_cilopang_agenda_metabox',
    10
);

function sdn_cilopang_hide_agenda_metabox()
{
    remove_meta_box('sdn_agenda_data', 'agenda', 'normal');
}

add_action('add_meta_boxes', 'sdn_cilopang_hide_agenda_metabox', 999);

function sdn_cilopang_agenda_title_placeholder($title)
{
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'agenda') {
        return $title;
    }

    return 'Judul Agenda';
}

add_filter('enter_title_here', 'sdn_cilopang_agenda_title_placeholder');

function sdn_cilopang_agenda_featured_image_label($content)
{
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'agenda') {
        return $content;
    }

    $content = str_replace('Featured image', 'Poster Agenda', $content);
    $content .= '<p class="description">Gunakan gambar yang jelas agar tampil baik pada halaman agenda.</p>';

    return $content;
}

add_filter('admin_post_thumbnail_html', 'sdn_cilopang_agenda_featured_image_label');

function sdn_cilopang_agenda_form_after_title()
{
    static $rendered = false;

    if ($rendered) {
        return;
    }

    $post_id = isset($_GET['post']) ? absint($_GET['post']) : 0;
    if (!$post_id && !empty($GLOBALS['post'])) {
        $post_id = (int) $GLOBALS['post']->ID;
    }

    if ($post_id) {
        $post_type = get_post_type($post_id);
    } else {
        $screen = function_exists('get_current_screen') ? get_current_screen() : null;
        $post_type = $screen ? $screen->post_type : '';
    }

    if ($post_type !== 'agenda') {
        return;
    }

    $rendered = true;
    $post = $post_id ? get_post($post_id) : (object) ['ID' => 0];
    sdn_cilopang_agenda_metabox_html($post);
}

add_action('edit_form_after_title', 'sdn_cilopang_agenda_form_after_title', 10);
add_action('edit_form_after_editor', 'sdn_cilopang_agenda_form_after_title', 10);

/**
 * Tampilan Meta Box
 */

function sdn_cilopang_agenda_metabox_html($post)
{
    wp_nonce_field(
        'sdn_cilopang_simpan_agenda',
        'sdn_cilopang_agenda_nonce'
    );

    $tanggal = get_post_meta(
        $post->ID,
        '_sdn_tanggal',
        true
    );

    $waktu = get_post_meta(
        $post->ID,
        '_sdn_waktu',
        true
    );

    $lokasi = get_post_meta(
        $post->ID,
        '_sdn_lokasi',
        true
    );
    ?>

    <div class="sdn-school-admin-shell">
        <div class="sdn-school-admin-section">
            <h3>Data Kegiatan</h3>
            <div class="sdn-school-admin-field">
                <span class="sdn-school-admin-help">Poster Agenda dapat dipilih melalui panel Gambar Unggulan di sebelah kanan.</span>
            </div>
            <div class="sdn-school-admin-field">
                <label for="sdn_tanggal">Tanggal Kegiatan</label>
                <input
                    type="date"
                    id="sdn_tanggal"
                    name="sdn_tanggal"
                    value="<?php echo esc_attr($tanggal); ?>"
                    class="widefat"
                >
                <small>Tentukan tanggal pelaksanaan kegiatan.</small>
            </div>
        </div>

        <div class="sdn-school-admin-section">
            <h3>Informasi Kegiatan</h3>
            <div class="sdn-school-admin-grid">
                <div class="sdn-school-admin-field">
                    <label for="sdn_waktu">Waktu Kegiatan</label>
                    <input
                        type="text"
                        id="sdn_waktu"
                        name="sdn_waktu"
                        value="<?php echo esc_attr($waktu); ?>"
                        class="widefat"
                        placeholder="Contoh: 07.00 - 10.00 WIB"
                    >
                </div>

                <div class="sdn-school-admin-field">
                    <label for="sdn_lokasi">Lokasi Kegiatan</label>
                    <input
                        type="text"
                        id="sdn_lokasi"
                        name="sdn_lokasi"
                        value="<?php echo esc_attr($lokasi); ?>"
                        class="widefat"
                        placeholder="Contoh: Halaman SDN Cilopang"
                    >
                </div>
            </div>
        </div>

        <div class="sdn-school-admin-section">
            <h3>Deskripsi Kegiatan</h3>
            <div class="sdn-school-admin-field">
                <span class="sdn-school-admin-label">Editor Deskripsi</span>
                <span class="sdn-school-admin-help">Tambahkan rincian kegiatan agar informasi mudah dipahami masyarakat sekolah.</span>
            </div>
        </div>
    </div>

    <?php
}


/**
 * =========================================================
 * SIMPAN DATA AGENDA
 * =========================================================
 */

function sdn_cilopang_simpan_agenda($post_id)
{
    if (
        !isset($_POST['sdn_cilopang_agenda_nonce']) ||
        !wp_verify_nonce(
            $_POST['sdn_cilopang_agenda_nonce'],
            'sdn_cilopang_simpan_agenda'
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
        get_post_type($post_id) !== 'agenda'
    ) {
        return;
    }

    if (isset($_POST['sdn_tanggal'])) {
        update_post_meta(
            $post_id,
            '_sdn_tanggal',
            sanitize_text_field($_POST['sdn_tanggal'])
        );
    }

    if (isset($_POST['sdn_waktu'])) {
        update_post_meta(
            $post_id,
            '_sdn_waktu',
            sanitize_text_field($_POST['sdn_waktu'])
        );
    }

    if (isset($_POST['sdn_lokasi'])) {
        update_post_meta(
            $post_id,
            '_sdn_lokasi',
            sanitize_text_field($_POST['sdn_lokasi'])
        );
    }
}

add_action(
    'save_post_agenda',
    'sdn_cilopang_simpan_agenda'
);


/**
 * =========================================================
 * SHORTCODE: DAFTAR AGENDA
 * =========================================================
 */

function sdn_cilopang_daftar_agenda()
{
    $query = new WP_Query([
        'post_type'      => 'agenda',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_key'       => '_sdn_tanggal',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
    ]);

    if (!$query->have_posts()) {
        return '<p>Belum ada agenda sekolah.</p>';
    }

    ob_start();
    ?>

    <div class="sdn-agenda-list">

        <?php while ($query->have_posts()) : $query->the_post(); ?>

            <?php
            $tanggal = get_post_meta(
                get_the_ID(),
                '_sdn_tanggal',
                true
            );

            $waktu = get_post_meta(
                get_the_ID(),
                '_sdn_waktu',
                true
            );

            $lokasi = get_post_meta(
                get_the_ID(),
                '_sdn_lokasi',
                true
            );
            ?>

            <article class="sdn-agenda-card">

                <div class="sdn-agenda-date">

                    <?php if ($tanggal) : ?>

                        <span class="sdn-agenda-day">
                            <?php echo esc_html(
                                date_i18n('d', strtotime($tanggal))
                            ); ?>
                        </span>

                        <span class="sdn-agenda-month">
                            <?php echo esc_html(
                                date_i18n('M', strtotime($tanggal))
                            ); ?>
                        </span>

                    <?php endif; ?>

                </div>

                <div class="sdn-agenda-content">

                    <h3>
                        <?php the_title(); ?>
                    </h3>

                    <?php if ($waktu) : ?>

                        <p>
                            <strong>Waktu:</strong>
                            <?php echo esc_html($waktu); ?>
                        </p>

                    <?php endif; ?>

                    <?php if ($lokasi) : ?>

                        <p>
                            <strong>Lokasi:</strong>
                            <?php echo esc_html($lokasi); ?>
                        </p>

                    <?php endif; ?>

                    <?php if (get_the_content()) : ?>

                        <div class="sdn-agenda-description">
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

// Agenda shortcode disabled by default for "static profile" mode.
// To re-enable, add this in a mu-plugin or via a filter: add_filter('sdn_cilopang_enable_agenda_shortcode', '__return_true');
if (apply_filters('sdn_cilopang_enable_agenda_shortcode', false)) {
    add_shortcode(
        'sdn_daftar_agenda',
        'sdn_cilopang_daftar_agenda'
    );
}