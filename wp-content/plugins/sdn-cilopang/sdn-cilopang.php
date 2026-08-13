<?php
/**
 * Plugin Name: SDN Cilopang
 * Description: Plugin khusus untuk website SDN Cilopang.
 * Version: 1.0.0
 * Author: KKN SDN Cilopang
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/class-fasilitas.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-ekstrakurikuler.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-agenda.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-pengaturan.php';

/**
 * =========================================================
 * DASHBOARD PLUGIN
 * =========================================================
 */

function sdn_cilopang_admin_menu()
{
    add_menu_page(
        'SDN Cilopang',
        'SDN Cilopang',
        'manage_options',
        'sdn-cilopang',
        'sdn_cilopang_dashboard',
        'dashicons-building',
        25
    );

    add_submenu_page(
        'sdn-cilopang',
        'Pengaturan Website',
        'Pengaturan Website',
        'manage_options',
        'sdn-cilopang-pengaturan',
        'sdn_cilopang_pengaturan_page'
    );
}

add_action('admin_menu', 'sdn_cilopang_admin_menu');


function sdn_cilopang_dashboard()
{
    ?>
    <div class="wrap">
        <h1>SDN Cilopang</h1>

        <p>Plugin SDN Cilopang berhasil diaktifkan.</p>

        <hr>

        <h2>Modul</h2>

        <ul>
            <li>Data Guru</li>
            <li>Fasilitas Sekolah</li>
            <li>Ekstrakurikuler</li>
            <li>Agenda Sekolah</li>
        </ul>
    </div>
    <?php
}


/**
 * =========================================================
 * CUSTOM POST TYPE: GURU
 * =========================================================
 */

function sdn_cilopang_register_guru()
{
    $labels = [
        'name'               => 'Guru',
        'singular_name'      => 'Guru',
        'menu_name'          => 'Data Guru',
        'add_new'            => 'Tambah Guru',
        'add_new_item'       => 'Tambah Guru',
        'edit_item'          => 'Edit Guru',
        'new_item'           => 'Guru Baru',
        'view_item'          => 'Lihat Guru',
        'search_items'       => 'Cari Guru',
        'not_found'          => 'Guru tidak ditemukan',
        'not_found_in_trash' => 'Guru tidak ditemukan di Trash',
    ];

    $args = [
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => 'sdn-cilopang',
        'menu_icon'     => 'dashicons-id',
        'supports'      => ['title', 'thumbnail'],
        'has_archive'   => true,
        'rewrite'       => [
            'slug' => 'guru',
        ],
        'show_in_rest'  => true,
    ];

    register_post_type('guru', $args);
}

add_action('init', 'sdn_cilopang_register_guru');


/**
 * =========================================================
 * META BOX DATA GURU
 * =========================================================
 */

function sdn_cilopang_guru_metabox()
{
    add_meta_box(
        'sdn_guru_data',
        'Informasi Guru',
        'sdn_cilopang_guru_metabox_html',
        'guru',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'sdn_cilopang_guru_metabox');


function sdn_cilopang_guru_metabox_html($post)
{
    wp_nonce_field(
        'sdn_cilopang_simpan_guru',
        'sdn_cilopang_guru_nonce'
    );

    $nip = get_post_meta($post->ID, '_sdn_nip', true);
    $nuptk = get_post_meta($post->ID, '_sdn_nuptk', true);
    $jabatan = get_post_meta($post->ID, '_sdn_jabatan', true);
    $mapel = get_post_meta($post->ID, '_sdn_mapel', true);
    $status = get_post_meta($post->ID, '_sdn_status', true);
    ?>

    <p>
        <label for="sdn_nip">
            <strong>NIP</strong>
        </label>

        <input
            type="text"
            id="sdn_nip"
            name="sdn_nip"
            value="<?php echo esc_attr($nip); ?>"
            class="widefat"
        >
    </p>

    <p>
        <label for="sdn_nuptk">
            <strong>NUPTK</strong>
        </label>

        <input
            type="text"
            id="sdn_nuptk"
            name="sdn_nuptk"
            value="<?php echo esc_attr($nuptk); ?>"
            class="widefat"
        >
    </p>

    <p>
        <label for="sdn_jabatan">
            <strong>Jabatan</strong>
        </label>

        <input
            type="text"
            id="sdn_jabatan"
            name="sdn_jabatan"
            value="<?php echo esc_attr($jabatan); ?>"
            class="widefat"
        >
    </p>

    <p>
        <label for="sdn_mapel">
            <strong>Mata Pelajaran</strong>
        </label>

        <input
            type="text"
            id="sdn_mapel"
            name="sdn_mapel"
            value="<?php echo esc_attr($mapel); ?>"
            class="widefat"
        >
    </p>

    <p>
        <label for="sdn_status">
            <strong>Status Kepegawaian</strong>
        </label>

        <select
            id="sdn_status"
            name="sdn_status"
            class="widefat"
        >
            <option value="">-- Pilih Status --</option>

            <option value="PNS" <?php selected($status, 'PNS'); ?>>
                PNS
            </option>

            <option value="PPPK" <?php selected($status, 'PPPK'); ?>>
                PPPK
            </option>

            <option value="Honorer" <?php selected($status, 'Honorer'); ?>>
                Honorer
            </option>

            <option value="Guru Tetap" <?php selected($status, 'Guru Tetap'); ?>>
                Guru Tetap
            </option>

            <option value="Lainnya" <?php selected($status, 'Lainnya'); ?>>
                Lainnya
            </option>
        </select>
    </p>

    <?php
}


/**
 * =========================================================
 * SIMPAN DATA GURU
 * =========================================================
 */

function sdn_cilopang_simpan_guru($post_id)
{
    if (
        !isset($_POST['sdn_cilopang_guru_nonce']) ||
        !wp_verify_nonce(
            $_POST['sdn_cilopang_guru_nonce'],
            'sdn_cilopang_simpan_guru'
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
        get_post_type($post_id) !== 'guru'
    ) {
        return;
    }

    $fields = [
        'sdn_nip',
        'sdn_nuptk',
        'sdn_jabatan',
        'sdn_mapel',
        'sdn_status',
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
    'save_post_guru',
    'sdn_cilopang_simpan_guru'
);


/**
 * =========================================================
 * SHORTCODE: DAFTAR GURU
 * =========================================================
 */

function sdn_cilopang_daftar_guru()
{
    $query = new WP_Query([
        'post_type'      => 'guru',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]);

    if (!$query->have_posts()) {
        return '<p>Belum ada data guru.</p>';
    }

    ob_start();
    ?>

    <div class="sdn-guru-grid">

        <?php while ($query->have_posts()) : $query->the_post(); ?>

            <?php
            $nip = get_post_meta(get_the_ID(), '_sdn_nip', true);
            $nuptk = get_post_meta(get_the_ID(), '_sdn_nuptk', true);
            $jabatan = get_post_meta(get_the_ID(), '_sdn_jabatan', true);
            $mapel = get_post_meta(get_the_ID(), '_sdn_mapel', true);
            $status = get_post_meta(get_the_ID(), '_sdn_status', true);
            ?>

          <a
    href="<?php echo esc_url(get_permalink()); ?>"
    class="sdn-guru-card"
>

    <div class="sdn-guru-photo">
        <?php
        if (has_post_thumbnail()) {
            the_post_thumbnail('medium');
        } else {
            echo '<div class="sdn-guru-no-photo">Tidak ada foto</div>';
        }
        ?>
    </div>

    <div class="sdn-guru-content">

        <h3>
            <?php the_title(); ?>
        </h3>

        <?php if ($jabatan) : ?>
            <p>
                <?php echo esc_html($jabatan); ?>
            </p>
        <?php endif; ?>

        <?php if ($mapel) : ?>
            <p>
                <?php echo esc_html($mapel); ?>
            </p>
        <?php endif; ?>

    </div>

</a>

        <?php endwhile; ?>

    </div>

    <?php

    wp_reset_postdata();

    return ob_get_clean();
}

add_shortcode(
    'sdn_daftar_guru',
    'sdn_cilopang_daftar_guru'
);


/**
 * =========================================================
 * LOAD CSS
 * =========================================================
 */

function sdn_cilopang_enqueue_styles()
{
    wp_enqueue_style(
        'sdn-cilopang-style',
        plugin_dir_url(__FILE__) . 'public/css/style.css',
        [],
        '1.0.0'
    );
}

add_action(
    'wp_enqueue_scripts',
    'sdn_cilopang_enqueue_styles'
);