<?php

if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option('sdn_cilopang_settings', []);
$nama_sekolah = $settings['nama_sekolah'] ?? 'SDN Cilopang';
$telepon = $settings['telepon'] ?? '';
$email = $settings['email'] ?? '';
$maps_short_link = 'https://maps.app.goo.gl/4aoTqQ1LAEkornNE6';
$alamat_singkat = 'Kp. Cilopang, Desa Loa, Paseh, Bandung';
$alamat_kontak = 'Kp. Cilopang, Desa Loa, Kecamatan Paseh, Kabupaten Bandung, Jawa Barat';
?>

<footer class="site-footer">

    <div class="container">

        <div class="footer-grid">

            <div class="footer-column footer-column--brand">

                <h3 class="footer-title"><?php echo esc_html($nama_sekolah); ?></h3>

                <p>
                    Website resmi SDN Cilopang sebagai media informasi dan komunikasi sekolah.
                </p>

                <p class="footer-contact-item">
                    <strong>Alamat singkat:</strong><br>
                    <?php echo esc_html($alamat_singkat); ?>
                </p>

            </div>

            <div class="footer-column footer-column--nav">

                <h3 class="footer-title">Navigasi Cepat</h3>

                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'fallback_cb'    => false,
                ]);
                ?>

            </div>

            <div class="footer-column footer-column--contact">

                <h3 class="footer-title">Kontak</h3>

                <p class="footer-contact-item">
                    <strong>Alamat:</strong><br>
                    <?php echo esc_html($alamat_kontak); ?>
                </p>

                <?php if ($telepon) : ?>
                    <p class="footer-contact-item">
                        <strong>Telepon:</strong><br>
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $telepon)); ?>"><?php echo esc_html($telepon); ?></a>
                    </p>
                <?php endif; ?>

                <?php if ($email) : ?>
                    <p class="footer-contact-item">
                        <strong>Email:</strong><br>
                        <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                    </p>
                <?php endif; ?>

                <p class="footer-contact-item">
                    <strong>Lokasi:</strong><br>
                    <a href="<?php echo esc_url($maps_short_link); ?>" target="_blank" rel="noopener noreferrer">Buka di Google Maps</a>
                </p>

            </div>

        </div>

        <div class="footer-bottom">
            © <?php echo esc_html(date('Y')); ?> <?php echo esc_html($nama_sekolah); ?>. All rights reserved.
        </div>

    </div>

</footer>

<?php wp_footer(); ?>

</body>
</html>