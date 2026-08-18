<?php

if (!defined('ABSPATH')) {
    exit;
}


/**
 * =========================================================
 * PENGATURAN WEBSITE SDN CILOPANG
 * =========================================================
 */

/**
 * Register Settings
 */
function sdn_cilopang_pengaturan_register()
{
    register_setting(
        'sdn_cilopang_pengaturan_group',
        'sdn_cilopang_settings',
        [
            'sanitize_callback' => 'sdn_cilopang_sanitize_settings',
        ]
    );
}

add_action(
    'admin_init',
    'sdn_cilopang_pengaturan_register'
);


/**
 * Sanitasi
 */
function sdn_cilopang_sanitize_settings($input)
{
    $output = [];

    $output['nama_sekolah'] = sanitize_text_field(
        $input['nama_sekolah'] ?? ''
    );

    $output['tagline'] = sanitize_text_field(
        $input['tagline'] ?? ''
    );

    $output['logo'] = absint(
        $input['logo'] ?? 0
    );

    $output['hero_judul'] = sanitize_text_field(
        $input['hero_judul'] ?? ''
    );

    $output['hero_deskripsi'] = sanitize_textarea_field(
        $input['hero_deskripsi'] ?? ''
    );

    $output['hero_image'] = absint(
        $input['hero_image'] ?? 0
    );

    $output['profil_judul'] = sanitize_text_field(
        $input['profil_judul'] ?? ''
    );

    $output['profil_deskripsi'] = sanitize_textarea_field(
        $input['profil_deskripsi'] ?? ''
    );

    $output['sejarah'] = sanitize_textarea_field(
        $input['sejarah'] ?? ''
    );

    $output['visi'] = sanitize_textarea_field(
        $input['visi'] ?? ''
    );

    $output['misi'] = sanitize_textarea_field(
        $input['misi'] ?? ''
    );

    $output['npsn'] = sanitize_text_field(
        $input['npsn'] ?? ''
    );

    $output['jumlah_siswa'] = sanitize_text_field(
        $input['jumlah_siswa'] ?? ''
    );

    $output['tahun_berdiri'] = sanitize_text_field(
        $input['tahun_berdiri'] ?? ''
    );

    $output['akreditasi'] = sanitize_text_field(
        $input['akreditasi'] ?? ''
    );

    $output['profil_image'] = absint(
        $input['profil_image'] ?? 0
    );

    $output['alamat'] = sanitize_textarea_field(
        $input['alamat'] ?? ''
    );

    $output['telepon'] = sanitize_text_field(
        $input['telepon'] ?? ''
    );

    $output['email'] = sanitize_email(
        $input['email'] ?? ''
    );

    $social_keys = [
        'facebook',
        'instagram',
        'youtube',
        'tiktok',
        'whatsapp',
    ];

    foreach ($social_keys as $key) {
        $output[$key] = esc_url_raw(
            $input[$key] ?? ''
        );
    }

    return $output;
}


/**
 * Enqueue Media Library
 */
function sdn_cilopang_pengaturan_media()
{
    if (
        isset($_GET['page']) &&
        $_GET['page'] === 'sdn-cilopang-pengaturan'
    ) {
        wp_enqueue_media();
    }
}

add_action(
    'admin_enqueue_scripts',
    'sdn_cilopang_pengaturan_media'
);


/**
 * Halaman Pengaturan
 */
function sdn_cilopang_pengaturan_page()
{
    $settings = get_option(
        'sdn_cilopang_settings',
        []
    );

    ?>

    <div class="wrap">

        <h1>Pengaturan Website SDN Cilopang</h1>

        <p>
            Gunakan halaman ini untuk mengatur identitas,
            gambar, informasi profil, dan kontak sekolah.
        </p>

        <form method="post" action="options.php">

            <?php
            settings_fields(
                'sdn_cilopang_pengaturan_group'
            );
            ?>

            <div
                style="
                    max-width:900px;
                    background:#fff;
                    padding:25px;
                    margin-top:20px;
                    border:1px solid #ddd;
                "
            >

                <h2>Identitas Sekolah</h2>

                <table class="form-table">

                    <tr>
                        <th>
                            <label for="nama_sekolah">
                                Nama Sekolah
                            </label>
                        </th>

                        <td>
                            <input
                                type="text"
                                id="nama_sekolah"
                                name="sdn_cilopang_settings[nama_sekolah]"
                                value="<?php echo esc_attr(
                                    $settings['nama_sekolah'] ?? 'SDN Cilopang'
                                ); ?>"
                                class="regular-text"
                            >
                        </td>
                    </tr>


                    <tr>
                        <th>
                            <label for="tagline">
                                Tagline
                            </label>
                        </th>

                        <td>
                            <input
                                type="text"
                                id="tagline"
                                name="sdn_cilopang_settings[tagline]"
                                value="<?php echo esc_attr(
                                    $settings['tagline'] ?? ''
                                ); ?>"
                                class="regular-text"
                                placeholder="Sekolah Dasar Negeri Cilopang"
                            >
                        </td>
                    </tr>


                    <tr>
                        <th>
                            Logo Sekolah
                        </th>

                        <td>

                            <?php
                            sdn_cilopang_image_field(
                                'logo',
                                $settings['logo'] ?? 0
                            );
                            ?>

                        </td>
                    </tr>

                </table>


                <hr>


                <h2>Hero Section</h2>

                <table class="form-table">

                    <tr>
                        <th>
                            Judul Hero
                        </th>

                        <td>

                            <input
                                type="text"
                                name="sdn_cilopang_settings[hero_judul]"
                                value="<?php echo esc_attr(
                                    $settings['hero_judul'] ?? ''
                                ); ?>"
                                class="regular-text"
                                placeholder="Selamat Datang di SDN Cilopang"
                            >

                        </td>
                    </tr>


                    <tr>
                        <th>
                            Deskripsi Hero
                        </th>

                        <td>

                            <textarea
                                name="sdn_cilopang_settings[hero_deskripsi]"
                                rows="4"
                                class="large-text"
                                placeholder="Membangun generasi..."
                            ><?php echo esc_textarea(
                                $settings['hero_deskripsi'] ?? ''
                            ); ?></textarea>

                        </td>
                    </tr>


                    <tr>
                        <th>
                            Gambar Hero
                        </th>

                        <td>

                            <?php
                            sdn_cilopang_image_field(
                                'hero_image',
                                $settings['hero_image'] ?? 0
                            );
                            ?>

                        </td>
                    </tr>

                </table>


                <hr>


                <h2>Profil Sekolah</h2>

                <table class="form-table">

                    <tr>
                        <th>
                            Judul Profil
                        </th>

                        <td>

                            <input
                                type="text"
                                name="sdn_cilopang_settings[profil_judul]"
                                value="<?php echo esc_attr(
                                    $settings['profil_judul'] ?? ''
                                ); ?>"
                                class="regular-text"
                                placeholder="Tentang SDN Cilopang"
                            >

                        </td>
                    </tr>


                    <tr>
                        <th>
                            Deskripsi Profil
                        </th>

                        <td>

                            <textarea
                                name="sdn_cilopang_settings[profil_deskripsi]"
                                rows="6"
                                class="large-text"
                            ><?php echo esc_textarea(
                                $settings['profil_deskripsi'] ?? ''
                            ); ?></textarea>

                        </td>
                    </tr>


                    <tr>
                        <th>
                            Sejarah
                        </th>

                        <td>

                            <textarea
                                name="sdn_cilopang_settings[sejarah]"
                                rows="5"
                                class="large-text"
                            ><?php echo esc_textarea(
                                $settings['sejarah'] ?? ''
                            ); ?></textarea>

                        </td>
                    </tr>


                    <tr>
                        <th>
                            Visi
                        </th>

                        <td>

                            <textarea
                                name="sdn_cilopang_settings[visi]"
                                rows="4"
                                class="large-text"
                            ><?php echo esc_textarea(
                                $settings['visi'] ?? ''
                            ); ?></textarea>

                        </td>
                    </tr>


                    <tr>
                        <th>
                            Misi
                        </th>

                        <td>

                            <textarea
                                name="sdn_cilopang_settings[misi]"
                                rows="4"
                                class="large-text"
                            ><?php echo esc_textarea(
                                $settings['misi'] ?? ''
                            ); ?></textarea>

                        </td>
                    </tr>


                    <tr>
                        <th>
                            NPSN
                        </th>

                        <td>

                            <input
                                type="text"
                                name="sdn_cilopang_settings[npsn]"
                                value="<?php echo esc_attr(
                                    $settings['npsn'] ?? ''
                                ); ?>"
                                class="regular-text"
                            >

                        </td>
                    </tr>

                    <tr>
                        <th>
                            Jumlah Siswa
                        </th>

                        <td>

                            <input
                                type="text"
                                name="sdn_cilopang_settings[jumlah_siswa]"
                                value="<?php echo esc_attr(
                                    $settings['jumlah_siswa'] ?? ''
                                ); ?>"
                                class="regular-text"
                            >

                        </td>
                    </tr>

                    <tr>
                        <th>
                            Tahun Berdiri
                        </th>

                        <td>

                            <input
                                type="text"
                                name="sdn_cilopang_settings[tahun_berdiri]"
                                value="<?php echo esc_attr(
                                    $settings['tahun_berdiri'] ?? ''
                                ); ?>"
                                class="regular-text"
                            >

                        </td>
                    </tr>

                    <tr>
                        <th>
                            Akreditasi
                        </th>

                        <td>

                            <input
                                type="text"
                                name="sdn_cilopang_settings[akreditasi]"
                                value="<?php echo esc_attr(
                                    $settings['akreditasi'] ?? ''
                                ); ?>"
                                class="regular-text"
                                placeholder="Contoh: A, B, atau Belum Terakreditasi"
                            >

                        </td>
                    </tr>


                    <tr>
                        <th>
                            Foto Sekolah
                        </th>

                        <td>

                            <?php
                            sdn_cilopang_image_field(
                                'profil_image',
                                $settings['profil_image'] ?? 0
                            );
                            ?>

                        </td>
                    </tr>

                </table>


                <hr>


                <h2>Kontak Sekolah</h2>

                <table class="form-table">

                    <tr>
                        <th>
                            Alamat
                        </th>

                        <td>

                            <textarea
                                name="sdn_cilopang_settings[alamat]"
                                rows="4"
                                class="large-text"
                            ><?php echo esc_textarea(
                                $settings['alamat'] ?? ''
                            ); ?></textarea>

                        </td>
                    </tr>


                    <tr>
                        <th>
                            Telepon
                        </th>

                        <td>

                            <input
                                type="text"
                                name="sdn_cilopang_settings[telepon]"
                                value="<?php echo esc_attr(
                                    $settings['telepon'] ?? ''
                                ); ?>"
                                class="regular-text"
                            >

                        </td>
                    </tr>


                    <tr>
                        <th>
                            Email
                        </th>

                        <td>

                            <input
                                type="email"
                                name="sdn_cilopang_settings[email]"
                                value="<?php echo esc_attr(
                                    $settings['email'] ?? ''
                                ); ?>"
                                class="regular-text"
                            >

                        </td>
                    </tr>

                    <tr>
                        <th>
                            Facebook
                        </th>

                        <td>
                            <input
                                type="url"
                                name="sdn_cilopang_settings[facebook]"
                                value="<?php echo esc_attr(
                                    $settings['facebook'] ?? ''
                                ); ?>"
                                class="regular-text"
                                placeholder="https://facebook.com/namaprofile"
                            >
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Instagram
                        </th>

                        <td>
                            <input
                                type="url"
                                name="sdn_cilopang_settings[instagram]"
                                value="<?php echo esc_attr(
                                    $settings['instagram'] ?? ''
                                ); ?>"
                                class="regular-text"
                                placeholder="https://instagram.com/namaprofile"
                            >
                        </td>
                    </tr>

                    <tr>
                        <th>
                            YouTube
                        </th>

                        <td>
                            <input
                                type="url"
                                name="sdn_cilopang_settings[youtube]"
                                value="<?php echo esc_attr(
                                    $settings['youtube'] ?? ''
                                ); ?>"
                                class="regular-text"
                                placeholder="https://youtube.com/@channel"
                            >
                        </td>
                    </tr>

                    <tr>
                        <th>
                            TikTok
                        </th>

                        <td>
                            <input
                                type="url"
                                name="sdn_cilopang_settings[tiktok]"
                                value="<?php echo esc_attr(
                                    $settings['tiktok'] ?? ''
                                ); ?>"
                                class="regular-text"
                                placeholder="https://tiktok.com/@namaprofile"
                            >
                        </td>
                    </tr>

                    <tr>
                        <th>
                            WhatsApp
                        </th>

                        <td>
                            <input
                                type="url"
                                name="sdn_cilopang_settings[whatsapp]"
                                value="<?php echo esc_attr(
                                    $settings['whatsapp'] ?? ''
                                ); ?>"
                                class="regular-text"
                                placeholder="https://wa.me/6281234567890"
                            >
                        </td>
                    </tr>

                </table>


                <?php submit_button('Simpan Pengaturan'); ?>

            </div>

        </form>

    </div>

    <?php
}


/**
 * Image Picker
 */
function sdn_cilopang_image_field(
    $field_name,
    $attachment_id
) {
    $image_url = '';

    if ($attachment_id) {
        $image_url = wp_get_attachment_image_url(
            $attachment_id,
            'medium'
        );
    }

    ?>

    <div
        class="sdn-image-field"
        data-field="<?php echo esc_attr($field_name); ?>"
    >

        <input
            type="hidden"
            name="sdn_cilopang_settings[<?php echo esc_attr($field_name); ?>]"
            value="<?php echo esc_attr($attachment_id); ?>"
            class="sdn-image-id"
        >

        <div
            class="sdn-image-preview"
            style="margin-bottom:10px;"
        >

            <?php if ($image_url) : ?>

                <img
                    src="<?php echo esc_url($image_url); ?>"
                    style="
                        max-width:250px;
                        max-height:150px;
                        object-fit:contain;
                    "
                >

            <?php endif; ?>

        </div>


        <button
            type="button"
            class="button sdn-select-image"
        >
            Pilih Gambar
        </button>


        <button
            type="button"
            class="button sdn-remove-image"
            <?php echo $image_url ? '' : 'style="display:none;"'; ?>
        >
            Hapus
        </button>

    </div>

    <?php
}


/**
 * JavaScript Media Picker
 */
function sdn_cilopang_pengaturan_script()
{
    if (
        !isset($_GET['page']) ||
        $_GET['page'] !== 'sdn-cilopang-pengaturan'
    ) {
        return;
    }

    ?>

    <script>

    jQuery(document).ready(function($) {

        $('.sdn-select-image').on('click', function(e) {

            e.preventDefault();

            const button = $(this);
            const wrapper = button.closest('.sdn-image-field');

            const frame = wp.media({
                title: 'Pilih Gambar',
                button: {
                    text: 'Gunakan Gambar'
                },
                multiple: false
            });

            frame.on('select', function() {

                const attachment =
                    frame.state().get('selection').first().toJSON();

                wrapper
                    .find('.sdn-image-id')
                    .val(attachment.id);

                wrapper
                    .find('.sdn-image-preview')
                    .html(
                        '<img src="' +
                        attachment.url +
                        '" style="max-width:250px;max-height:150px;object-fit:contain;">'
                    );

                wrapper
                    .find('.sdn-remove-image')
                    .show();

            });

            frame.open();

        });


        $('.sdn-remove-image').on('click', function(e) {

            e.preventDefault();

            const wrapper =
                $(this).closest('.sdn-image-field');

            wrapper
                .find('.sdn-image-id')
                .val('');

            wrapper
                .find('.sdn-image-preview')
                .html('');

            $(this).hide();

        });

    });

    </script>

    <?php
}

add_action(
    'admin_footer',
    'sdn_cilopang_pengaturan_script'
);