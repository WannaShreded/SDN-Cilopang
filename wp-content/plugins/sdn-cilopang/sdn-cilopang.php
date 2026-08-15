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

function sdn_cilopang_rename_post_labels()
{
    global $wp_post_types;

    if (isset($wp_post_types['post'])) {
        $post_type = $wp_post_types['post'];
        $post_type->labels->name = 'Berita';
        $post_type->labels->singular_name = 'Berita';
        $post_type->labels->menu_name = 'Berita';
        $post_type->labels->add_new = 'Tambah Berita';
        $post_type->labels->add_new_item = 'Tambah Berita';
        $post_type->labels->edit_item = 'Edit Berita';
        $post_type->labels->new_item = 'Berita Baru';
        $post_type->labels->view_item = 'Lihat Berita';
        $post_type->labels->search_items = 'Cari Berita';
        $post_type->labels->not_found = 'Berita tidak ditemukan';
        $post_type->labels->not_found_in_trash = 'Berita tidak ditemukan di sampah';
    }
}

add_action('init', 'sdn_cilopang_rename_post_labels');

function sdn_cilopang_rename_admin_post_menu()
{
    global $menu, $submenu;

    foreach ($menu as $index => $item) {
        if (isset($item[2]) && $item[2] === 'edit.php') {
            $menu[$index][0] = 'Berita';
            break;
        }
    }

    if (!empty($submenu['edit.php'])) {
        foreach ($submenu['edit.php'] as $sub_index => $sub_item) {
            if (isset($sub_item[2]) && $sub_item[2] === 'post-new.php') {
                $submenu['edit.php'][$sub_index][0] = 'Tambah Berita';
                break;
            }
        }
    }
}

add_action('admin_menu', 'sdn_cilopang_rename_admin_post_menu', 999);

function sdn_cilopang_admin_menu()
{
    add_menu_page(
        'SDN Cilopang',
        'SDN Cilopang',
        'edit_posts',
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

    if (current_user_can('edit_theme_options')) {
        add_submenu_page(
            'sdn-cilopang',
            'Menu Situs',
            'Menu',
            'edit_theme_options',
            'nav-menus.php'
        );
    }
}

add_action('admin_menu', 'sdn_cilopang_admin_menu');

function sdn_cilopang_hide_unneeded_admin_pages()
{
    if (current_user_can('manage_options')) {
        return;
    }

    // Hide pages not needed by operator role
    remove_menu_page('edit.php?post_type=page');
    remove_menu_page('edit-comments.php');
    remove_menu_page('plugins.php');
    remove_menu_page('users.php');
    remove_menu_page('tools.php');
    remove_menu_page('options-general.php');

    // Hide Posts (Berita) and Agenda from operator users
    remove_menu_page('edit.php'); // Posts (Berita)
    remove_menu_page('edit.php?post_type=agenda'); // Agenda CPT

    remove_submenu_page('themes.php', 'theme-editor.php');
    remove_submenu_page('themes.php', 'customize.php');
}

add_action('admin_menu', 'sdn_cilopang_hide_unneeded_admin_pages', 999);

// Additionally remove Agenda admin menu for ALL users to fully disable the feature
function sdn_cilopang_remove_agenda_menu()
{
    remove_menu_page('edit.php?post_type=agenda');
}
add_action('admin_menu', 'sdn_cilopang_remove_agenda_menu', 1);

// Block direct admin access to agenda screens (even via direct URL)
function sdn_cilopang_block_agenda_admin_access()
{
    if (!is_admin()) {
        return;
    }

    // If someone visits edit.php?post_type=agenda
    if (isset($_GET['post_type']) && $_GET['post_type'] === 'agenda') {
        wp_safe_redirect(admin_url());
        exit;
    }

    // If someone visits post.php?post={id}&action=edit for an agenda post
    if (isset($_GET['post']) && isset($_GET['action']) && $_GET['action'] === 'edit') {
        $post_id = absint($_GET['post']);
        $post = get_post($post_id);
        if ($post && $post->post_type === 'agenda') {
            wp_safe_redirect(admin_url());
            exit;
        }
    }
}
add_action('admin_init', 'sdn_cilopang_block_agenda_admin_access', 1);

// Flush rewrite rules once in admin to ensure /agenda/ routes are removed
add_action('admin_init', function () {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (!get_option('sdn_cilopang_agenda_rewrite_flushed')) {
        flush_rewrite_rules();
        update_option('sdn_cilopang_agenda_rewrite_flushed', 1);
    }
}, 20);

/**
 * =========================================================
 * DISABLE BERITA (native posts) PUBLIC & ADMIN FOR OPERATORS
 * =========================================================
 */

// Block public view of single posts and category pages for berita/pengumuman
function sdn_cilopang_block_berita_public()
{
    if (is_admin()) {
        return;
    }

    // Single native post
    if (is_singular('post')) {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        nocache_headers();
        include get_query_template('404');
        exit;
    }

    // Category pages with slug 'berita' or 'pengumuman'
    if (is_category()) {
        $cat = get_queried_object();
        if ($cat && is_object($cat)) {
            $slug = strtolower($cat->slug);
            $name = strtolower($cat->name);
            if (in_array($slug, ['berita', 'pengumuman'], true) || in_array($name, ['berita', 'pengumuman'], true)) {
                global $wp_query;
                $wp_query->set_404();
                status_header(404);
                nocache_headers();
                include get_query_template('404');
                exit;
            }
        }
    }
}
add_action('template_redirect', 'sdn_cilopang_block_berita_public', 1);

// Block operator access to Posts admin screens (list and edit)
function sdn_cilopang_block_posts_admin_access()
{
    if (current_user_can('manage_options')) {
        return;
    }

    if (!function_exists('get_current_screen')) {
        return;
    }

    $screen = get_current_screen();
    if (!$screen) {
        return;
    }

    // Posts list screen ID is 'edit-post', single post edit screen ID is 'post'
    if ($screen->id === 'edit-post' || ($screen->id === 'post' && $screen->post_type === 'post')) {
        wp_safe_redirect(admin_url());
        exit;
    }
}
add_action('admin_init', 'sdn_cilopang_block_posts_admin_access', 1);

// Also remove Posts menu for non-admin users (defense-in-depth)
add_action('admin_menu', function () {
    if (!current_user_can('manage_options')) {
        remove_menu_page('edit.php');
    }
}, 100);

// Remove public category link references in nav/footer should be handled in theme (templates), but ensure homepage Berita removed earlier.


function sdn_cilopang_hide_dashboard_widgets()
{
    if (current_user_can('manage_options')) {
        return;
    }

    $widgets = [
        'dashboard_welcome_panel',
        'dashboard_right_now',
        'dashboard_activity',
        'dashboard_quick_press',
        'dashboard_recent_drafts',
        'dashboard_primary',
        'dashboard_secondary',
        'dashboard_plugins',
        'dashboard_incoming_links',
        'dashboard_recent_comments',
        'dashboard_php_nag',
    ];

    foreach ($widgets as $widget_id) {
        remove_meta_box($widget_id, 'dashboard', 'normal');
        remove_meta_box($widget_id, 'dashboard', 'side');
    }
}

add_action('wp_dashboard_setup', 'sdn_cilopang_hide_dashboard_widgets', 999);

function sdn_cilopang_dashboard_welcome_content()
{
    $items = [
        ['Berita', admin_url('edit.php'), 'dashicons-admin-post'],
        // Agenda intentionally removed from dashboard shortcuts - feature disabled
        ['Guru & Tendik', admin_url('edit.php?post_type=guru'), 'dashicons-id'],
        ['Fasilitas', admin_url('edit.php?post_type=fasilitas'), 'dashicons-building'],
        ['Ekstrakurikuler', admin_url('edit.php?post_type=ekstrakurikuler'), 'dashicons-groups'],
    ];

    // Remove Berita shortcut for non-admin users
    if (!current_user_can('manage_options')) {
        $items = array_filter($items, function($it) {
            return $it[0] !== 'Berita';
        });
        $items = array_values($items);
    }

    if (current_user_can('manage_options')) {
        $items[] = ['Pengaturan Website', admin_url('admin.php?page=sdn-cilopang-pengaturan'), 'dashicons-admin-settings'];
    }

    echo '<div class="sdn-admin-dashboard-wrap">';
    echo '<p class="sdn-admin-dashboard-subtitle">Kelola informasi dan konten website sekolah.</p>';
    echo '<div class="sdn-admin-dashboard-grid">';

    foreach ($items as $item) {
        [$label, $url, $icon] = $item;
        echo '<a class="sdn-admin-dashboard-card" href="' . esc_url($url) . '">';
        echo '<span class="sdn-admin-dashboard-icon ' . esc_attr($icon) . '"></span>';
        echo '<span class="sdn-admin-dashboard-label">' . esc_html($label) . '</span>';
        echo '</a>';
    }

    echo '</div>';
    echo '</div>';

    echo '<style>
        .sdn-admin-dashboard-wrap {
            padding: 4px 0 0;
        }
        .sdn-admin-dashboard-subtitle {
            margin: 0 0 18px;
            font-size: 13px;
            color: #475569;
        }
        .sdn-admin-dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            margin-top: 8px;
        }
        .sdn-admin-dashboard-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 14px;
            border: 1px solid #dfe7f1;
            border-radius: 10px;
            background: #f8fafc;
            color: #172033;
            text-decoration: none;
            box-shadow: none;
        }
        .sdn-admin-dashboard-card:hover,
        .sdn-admin-dashboard-card:focus {
            background: #eef4ff;
            border-color: #bfd4ff;
            color: #172033;
            text-decoration: none;
        }
        .sdn-admin-dashboard-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #e2e8f0;
            color: #1d4ed8;
            font-size: 18px;
            line-height: 1;
        }
        .sdn-admin-dashboard-label {
            font-weight: 600;
            font-size: 14px;
        }
    </style>';
}

add_action('wp_dashboard_setup', function () {
    add_meta_box('sdn_cilopang_dashboard_welcome', 'Website SDN Cilopang', 'sdn_cilopang_dashboard_welcome_content', 'dashboard', 'normal', 'high');
}, 100);

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
        'name'               => 'Guru & Tendik',
        'singular_name'      => 'Guru & Tendik',
        'menu_name'          => 'Guru & Tendik',
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

add_action('add_meta_boxes', 'sdn_cilopang_guru_metabox', 10);

function sdn_cilopang_hide_guru_metabox()
{
    remove_meta_box('sdn_guru_data', 'guru', 'normal');
}

add_action('add_meta_boxes', 'sdn_cilopang_hide_guru_metabox', 999);

function sdn_cilopang_unified_admin_styles($hook)
{
    if (!in_array($hook, ['post.php', 'post-new.php'], true)) {
        return;
    }

    $screen = get_current_screen();
    if (!$screen || !in_array($screen->post_type, ['guru', 'fasilitas', 'ekstrakurikuler', 'post'], true)) {
        return;
    }

    $css = "
        .sdn-school-admin-shell {
            margin-top: 12px;
            padding: 0;
        }
        .sdn-school-admin-section {
            margin: 18px 0 12px;
            padding: 14px 16px;
            border: 1px solid #dfe7f1;
            border-radius: 10px;
            background: #f8fafc;
        }
        .sdn-school-admin-section h3 {
            margin: 0 0 12px;
            font-size: 13px;
            line-height: 1.4;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #1d4ed8;
        }
        .sdn-school-admin-field {
            margin: 0 0 16px;
        }
        .sdn-school-admin-field:last-child {
            margin-bottom: 0;
        }
        .sdn-school-admin-field label,
        .sdn-school-admin-label {
            display: block;
            margin: 0 0 8px;
            font-weight: 600;
            color: #172033;
        }
        .sdn-school-admin-field .description,
        .sdn-school-admin-field small,
        .sdn-school-admin-help {
            display: block;
            margin-top: 6px;
            color: #64748b;
            font-size: 12px;
            line-height: 1.5;
        }
        .sdn-school-admin-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }
        @media (max-width: 782px) {
            .sdn-school-admin-grid {
                grid-template-columns: 1fr;
            }
        }
        #sdn_guru_data,
        #sdn_agenda_data,
        #sdn_ekstrakurikuler_data {
            display: none !important;
        }
        #titlediv .inside {
            padding-top: 10px;
        }
        #titlewrap label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #172033;
        }
        #postimagediv > h2 span {
            font-size: 13px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }
    ";

    wp_add_inline_style('wp-admin', $css);
}

add_action('admin_enqueue_scripts', 'sdn_cilopang_unified_admin_styles');

function sdn_cilopang_get_post_type_for_inline_form()
{
    $post_id = 0;

    if (isset($_GET['post'])) {
        $post_id = absint($_GET['post']);
    } elseif (isset($_POST['post_ID'])) {
        $post_id = absint($_POST['post_ID']);
    } elseif (!empty($GLOBALS['post'])) {
        $post_id = (int) $GLOBALS['post']->ID;
    }

    if ($post_id) {
        return get_post_type($post_id);
    }

    $screen = function_exists('get_current_screen') ? get_current_screen() : null;

    return $screen ? $screen->post_type : '';
}

function sdn_cilopang_guru_title_label()
{
    static $rendered = false;

    if ($rendered) {
        return;
    }

    if (sdn_cilopang_get_post_type_for_inline_form() !== 'guru') {
        return;
    }

    $post_id = isset($_GET['post']) ? absint($_GET['post']) : 0;
    if (!$post_id && !empty($GLOBALS['post'])) {
        $post_id = (int) $GLOBALS['post']->ID;
    }

    $post = $post_id ? get_post($post_id) : (object) ['ID' => 0];
    $rendered = true;
    sdn_cilopang_guru_metabox_html($post);
}

add_action('edit_form_after_title', 'sdn_cilopang_guru_title_label', 10);
add_action('edit_form_after_editor', 'sdn_cilopang_guru_title_label', 10);

function sdn_cilopang_guru_title_placeholder($title)
{
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'guru') {
        return $title;
    }

    return 'Nama Guru';
}

add_filter('enter_title_here', 'sdn_cilopang_guru_title_placeholder');

function sdn_cilopang_guru_featured_image_label($content)
{
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'guru') {
        return $content;
    }

    $content = str_replace('Featured image', 'Foto Guru', $content);
    $content .= '<p class="description">Gunakan foto dengan orientasi tegak agar tampil rapi di website.</p>';

    return $content;
}

add_filter('admin_post_thumbnail_html', 'sdn_cilopang_guru_featured_image_label');

function sdn_cilopang_post_title_placeholder($title)
{
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'post') {
        return $title;
    }

    return 'Judul Berita';
}

add_filter('enter_title_here', 'sdn_cilopang_post_title_placeholder');

function sdn_cilopang_post_featured_image_label($content)
{
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'post') {
        return $content;
    }

    $content = str_replace('Featured image', 'Foto Berita', $content);
    $content .= '<p class="description">Gunakan foto yang jelas agar berita tampil lebih menarik di website.</p>';

    return $content;
}

add_filter('admin_post_thumbnail_html', 'sdn_cilopang_post_featured_image_label');

function sdn_cilopang_post_form_panel()
{
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'post') {
        return;
    }

    echo '<div class="sdn-school-admin-shell">';
    echo '<div class="sdn-school-admin-section">';
    echo '<h3>Data Utama</h3>';
    echo '<div class="sdn-school-admin-label">Foto Berita</div>';
    echo '<div class="sdn-school-admin-help">Gunakan foto yang jelas agar berita tampil lebih menarik di website.</div>';
    echo '</div>';
    echo '<div class="sdn-school-admin-section">';
    echo '<h3>Isi Berita</h3>';
    echo '<div class="sdn-school-admin-help">Gunakan editor di bawah ini untuk menulis isi berita lengkap dan informatif.</div>';
    echo '</div>';
    echo '</div>';
}

add_action('edit_form_after_title', 'sdn_cilopang_post_form_panel');

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

    <div class="sdn-school-admin-shell">
        <div class="sdn-school-admin-section">
            <h3>Informasi Kepegawaian</h3>
            <div class="sdn-school-admin-grid">
                <div class="sdn-school-admin-field">
                    <label for="sdn_nip">NIP</label>
                    <input
                        type="text"
                        id="sdn_nip"
                        name="sdn_nip"
                        value="<?php echo esc_attr($nip); ?>"
                        class="widefat"
                        placeholder="Masukkan NIP"
                    >
                    <small>Masukkan NIP sesuai data administrasi sekolah.</small>
                </div>

                <div class="sdn-school-admin-field">
                    <label for="sdn_nuptk">NUPTK</label>
                    <input
                        type="text"
                        id="sdn_nuptk"
                        name="sdn_nuptk"
                        value="<?php echo esc_attr($nuptk); ?>"
                        class="widefat"
                        placeholder="Masukkan NUPTK"
                    >
                    <small>Masukkan NUPTK jika tersedia.</small>
                </div>

                <div class="sdn-school-admin-field">
                    <label for="sdn_jabatan">Jabatan</label>
                    <input
                        type="text"
                        id="sdn_jabatan"
                        name="sdn_jabatan"
                        value="<?php echo esc_attr($jabatan); ?>"
                        class="widefat"
                        placeholder="Contoh: Guru Kelas"
                    >
                </div>

                <div class="sdn-school-admin-field">
                    <label for="sdn_mapel">Mata Pelajaran</label>
                    <input
                        type="text"
                        id="sdn_mapel"
                        name="sdn_mapel"
                        value="<?php echo esc_attr($mapel); ?>"
                        class="widefat"
                        placeholder="Contoh: Matematika"
                    >
                </div>
            </div>

            <div class="sdn-school-admin-field" style="margin-top: 16px;">
                <label for="sdn_status">Status Kepegawaian</label>
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
            </div>
        </div>
    </div>

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