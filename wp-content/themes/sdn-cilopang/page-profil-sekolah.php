<?php

if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option(
    'sdn_cilopang_settings',
    []
);

$nama_sekolah = $settings['nama_sekolah'] ?? 'SDN Cilopang';
$tagline = $settings['tagline'] ?? '';
$hero_description = $settings['profil_deskripsi'] ?? '';
$profil_image_id = absint($settings['profil_image'] ?? 0);
$profil_image_url = $profil_image_id
    ? wp_get_attachment_image_url($profil_image_id, 'large')
    : '';
$profil_judul = $settings['profil_judul'] ?? '';
$sejarah = $settings['sejarah'] ?? '';
$npsn = $settings['npsn'] ?? '';
$alamat = $settings['alamat'] ?? '';
$telepon = $settings['telepon'] ?? '';
$email = $settings['email'] ?? '';
$visi = $settings['visi'] ?? '';
$misi = $settings['misi'] ?? '';

$misi_items = array_filter(
    preg_split('/\r\n|\r|\n/', trim($misi)),
    'strlen'
);

get_header();
?>

<main>

    <section class="section section-profile-hero">

        <div class="container">

            <div class="section-header">

                <div class="section-label">
                    PROFIL SEKOLAH
                </div>

                <h1 class="section-title">
                    <?php echo esc_html($nama_sekolah); ?>
                </h1>

                <?php if ($tagline) : ?>
                    <p class="section-description">
                        <?php echo esc_html($tagline); ?>
                    </p>
                <?php endif; ?>

                <?php if ($hero_description) : ?>
                    <p class="section-description">
                        <?php echo esc_html($hero_description); ?>
                    </p>
                <?php endif; ?>

            </div>

        </div>

    </section>

    <section class="section section-profile-about">

        <div class="container">

            <div class="section-header">

                <div class="section-label">
                    TENTANG SEKOLAH
                </div>

                <h2 class="section-title">
                    <?php echo esc_html($profil_judul ?: 'Tentang Sekolah'); ?>
                </h2>

            </div>

            <?php if ($profil_image_url) : ?>
                <div class="profile-image">
                    <img
                        src="<?php echo esc_url($profil_image_url); ?>"
                        alt="<?php echo esc_attr($profil_judul ?: $nama_sekolah); ?>"
                    >
                </div>
            <?php endif; ?>

            <?php if ($sejarah) : ?>
                <div class="profile-sejarah">
                    <?php echo nl2br(esc_html($sejarah)); ?>
                </div>
            <?php endif; ?>

        </div>

    </section>

    <section class="section section-school-identity">

        <div class="container">

            <div class="section-header">

                <div class="section-label">
                    IDENTITAS SEKOLAH
                </div>

                <h2 class="section-title">
                    Identitas Sekolah
                </h2>

            </div>

            <div class="school-identity">

                <div class="identity-grid" role="table" aria-label="Identitas Sekolah">

                    <div class="identity-row">
                        <div class="identity-key" role="rowheader">Nama Sekolah</div>
                        <div class="identity-value" role="cell"><?php echo esc_html($nama_sekolah); ?></div>
                    </div>

                    <?php if ($npsn) : ?>
                        <div class="identity-row">
                            <div class="identity-key" role="rowheader">NPSN</div>
                            <div class="identity-value" role="cell"><?php echo esc_html($npsn); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($alamat) : ?>
                        <div class="identity-row">
                            <div class="identity-key" role="rowheader">Alamat</div>
                            <div class="identity-value" role="cell"><?php echo nl2br(esc_html($alamat)); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($telepon) : ?>
                        <div class="identity-row">
                            <div class="identity-key" role="rowheader">Telepon</div>
                            <div class="identity-value" role="cell"><?php echo esc_html($telepon); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($email) : ?>
                        <div class="identity-row">
                            <div class="identity-key" role="rowheader">Email</div>
                            <div class="identity-value" role="cell"><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></div>
                        </div>
                    <?php endif; ?>

                </div>

            </div>

        </div>

    </section>

    <?php if ($visi) : ?>
        <section class="section section-school-vision">

            <div class="container">

                <div class="section-header">

                    <div class="section-label">
                        VISI
                    </div>

                    <h2 class="section-title">
                        Visi
                    </h2>

                </div>

                <div class="school-vision">
                    <p><?php echo nl2br(esc_html($visi)); ?></p>
                </div>

            </div>

        </section>
    <?php endif; ?>

    <?php if ($misi) : ?>
        <section class="section section-school-mission">

            <div class="container">

                <div class="section-header">

                    <div class="section-label">
                        MISI
                    </div>

                    <h2 class="section-title">
                        Misi
                    </h2>

                </div>

                <div class="school-mission">
                    <?php if (count($misi_items) > 1) : ?>
                        <ul>
                            <?php foreach ($misi_items as $item) : ?>
                                <li><?php echo esc_html(trim($item)); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p><?php echo esc_html($misi); ?></p>
                    <?php endif; ?>
                </div>

            </div>

        </section>
    <?php endif; ?>

</main>

<?php
get_footer();
