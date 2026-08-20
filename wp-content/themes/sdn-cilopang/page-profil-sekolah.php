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

                

            </div>

            <div class="profile-wide-grid">

                <div class="profile-col-photo">
                    <?php if ($profil_image_url) : ?>
                        <div class="profile-photo-wrap">
                            <img
                                src="<?php echo esc_url($profil_image_url); ?>"
                                alt="<?php echo esc_attr($profil_judul ?: $nama_sekolah); ?>"
                            >
                        </div>
                    <?php else : ?>
                        <div class="profile-photo-wrap no-photo" aria-hidden="true"></div>
                    <?php endif; ?>
                </div>

                <div class="profile-col-content">

                    <h3 class="profile-col-title"><?php echo esc_html($nama_sekolah); ?></h3>

                    <?php if ($hero_description) : ?>
                        <p class="profile-intro"><?php echo nl2br(esc_html($hero_description)); ?></p>
                    <?php endif; ?>

                    <?php if ($sejarah) : ?>
                        <div class="profile-sejarah-extended">
                            <?php echo nl2br(esc_html($sejarah)); ?>
                        </div>
                    <?php endif; ?>

                </div>

            </div>

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

                <div class="identity-grid two-column" role="table" aria-label="Identitas Sekolah">

                    <div class="identity-item">
                        <div class="identity-key">Nama Sekolah</div>
                        <div class="identity-value"><?php echo esc_html($nama_sekolah); ?></div>
                    </div>

                    <?php if ($npsn) : ?>
                        <div class="identity-item">
                            <div class="identity-key">NPSN</div>
                            <div class="identity-value"><?php echo esc_html($npsn); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($alamat) : ?>
                        <div class="identity-item">
                            <div class="identity-key">Alamat</div>
                            <div class="identity-value"><?php echo nl2br(esc_html($alamat)); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($telepon) : ?>
                        <div class="identity-item">
                            <div class="identity-key">Telepon</div>
                            <div class="identity-value"><?php echo esc_html($telepon); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($email) : ?>
                        <div class="identity-item">
                            <div class="identity-key">Email</div>
                            <div class="identity-value"><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></div>
                        </div>
                    <?php endif; ?>

                </div>

            </div>

        </div>

    </section>

    <?php if ($visi || $misi) : ?>
        <section class="section section-vision-mission">

            <div class="container">

                <div class="section-header">

                    <div class="section-label">
                        VISI &amp; MISI
                    </div>

                    <h2 class="section-title">
                        Visi &amp; Misi
                    </h2>

                </div>

                <div class="vm-grid">

                    <div class="vm-card vm-vision">
                        <h3>Visi</h3>
                        <div class="vm-content">
                            <?php echo nl2br(esc_html($visi)); ?>
                        </div>
                    </div>

                    <div class="vm-card vm-mission">
                        <h3>Misi</h3>
                        <div class="vm-content">
                            <?php if ($misi) : ?>
                                <?php if (count($misi_items) > 1) : ?>
                                    <ul>
                                        <?php foreach ($misi_items as $item) : ?>
                                            <li><?php echo esc_html(trim($item)); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else : ?>
                                    <p><?php echo esc_html($misi); ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

            </div>

        </section>
    <?php endif; ?>

</main>

<?php
get_footer();
