<?php

if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option('sdn_cilopang_settings', []);

$nama_sekolah = $settings['nama_sekolah'] ?? 'SDN Cilopang';
$alamat = $settings['alamat'] ?? '';
$telepon = $settings['telepon'] ?? '';
$email = $settings['email'] ?? '';

// fixed display address for map/location per request
$fixed_address = 'Kp. Cilopang, Desa Loa, Kecamatan Paseh, Kabupaten Bandung, Jawa Barat';

// prepare tel link (digits only)
$tel_link = '';
if ($telepon) {
    $digits = preg_replace('/[^0-9+]/', '', $telepon);
    if ($digits) {
        $tel_link = 'tel:' . $digits;
    }
}

// Google Maps short link from request
$maps_short_link = 'https://maps.app.goo.gl/E4wPQ1yHGyz6AWow5';

get_header();
?>

<main class="contact-page">

    <section class="section section-contact-hero">
        <div class="container">
            <div class="section-header">

                <div class="section-label">HUBUNGI KAMI</div>

                <h1 class="section-title">Kontak Sekolah</h1>

                <p class="section-description">
                    Halaman ini berisi informasi kontak resmi sekolah. Silakan gunakan data di bawah untuk menghubungi pihak sekolah.
                </p>

            </div>
        </div>
    </section>

    <!-- Contact page styles moved to style.css -->

    <section class="section page-contact-info">
        <div class="container">

            <div class="contact-grid">

                <div class="contact-info">

                    <div class="section-header">
                        <h2 class="section-title">Informasi Kontak</h2>
                    </div>

                    <div class="contact-details">

                        <p>
                            <strong>Nama Sekolah:</strong>
                            <?php echo esc_html($nama_sekolah); ?>
                        </p>

                        <?php if ($alamat) : ?>
                            <p>
                                <strong>Alamat:</strong>
                                <?php echo nl2br(esc_html($alamat)); ?>
                            </p>
                        <?php endif; ?>

                        <p>
                            <strong>Alamat Lokasi:</strong>
                            <?php echo esc_html($fixed_address); ?>
                        </p>

                        <?php if ($telepon) : ?>
                            <p>
                                <strong>Telepon:</strong>
                                <?php if ($tel_link) : ?>
                                    <a href="<?php echo esc_url($tel_link); ?>"><?php echo esc_html($telepon); ?></a>
                                <?php else : ?>
                                    <?php echo esc_html($telepon); ?>
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($email) : ?>
                            <p>
                                <strong>Email:</strong>
                                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                            </p>
                        <?php endif; ?>

                    </div>

                </div>

                <div class="contact-map">

                    <div class="section-header">
                        <h2 class="section-title">Lokasi</h2>
                    </div>

                    <div class="contact-map-box">

                        <div style="width:100%">

                            <iframe
                                src="<?php echo esc_url('https://www.google.com/maps?q=' . rawurlencode($fixed_address) . '&output=embed'); ?>"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                title="Peta lokasi SDN Cilopang"
                            ></iframe>

                            <div style="margin-top:12px;text-align:center;">
                                <a class="btn" href="<?php echo esc_url($maps_short_link); ?>" target="_blank" rel="noopener noreferrer">Buka di Google Maps</a>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

    <section class="section page-contact-cta">
        <div class="container">

            <div class="section-header">
                <h2 class="section-title">Butuh informasi lebih lanjut?</h2>
            </div>

            <p class="section-description">Jika Anda membutuhkan informasi tambahan, silakan hubungi kami melalui telepon atau email.</p>

            <div class="contact-cta">

                <?php if ($tel_link) : ?>
                    <a class="btn btn-primary" href="<?php echo esc_url($tel_link); ?>">Hubungi via Telepon</a>
                <?php endif; ?>

                <?php if ($email) : ?>
                    <a class="btn" href="mailto:<?php echo esc_attr($email); ?>">Kirim Email</a>
                <?php endif; ?>

            </div>

        </div>
    </section>

</main>

<?php
get_footer();
?>
