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
$social_profiles = [
    'facebook' => ['label' => 'Facebook', 'url' => $settings['facebook'] ?? ''],
    'instagram' => ['label' => 'Instagram', 'url' => $settings['instagram'] ?? ''],
    'youtube' => ['label' => 'YouTube', 'url' => $settings['youtube'] ?? ''],
    'tiktok' => ['label' => 'TikTok', 'url' => $settings['tiktok'] ?? ''],
    'whatsapp' => ['label' => 'WhatsApp', 'url' => $settings['whatsapp'] ?? ''],
];
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

                <?php $has_social = false; foreach ($social_profiles as $profile) { if (!empty($profile['url'])) { $has_social = true; break; } } ?>
                <?php if ($has_social) : ?>
                    <div class="footer-social">
                        <h3 class="footer-title">Social Media</h3>
                        <div class="footer-social-links" aria-label="Social Media SDN Cilopang">
                            <?php foreach ($social_profiles as $key => $profile) : ?>
                                <?php if (empty($profile['url'])) continue; ?>
                                <a
                                    class="footer-social-link"
                                    href="<?php echo esc_url($profile['url']); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label="<?php echo esc_attr($profile['label']); ?>"
                                    title="<?php echo esc_attr($profile['label']); ?>"
                                >
                                    <?php
                                    $svg = [
                                        'facebook' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 8.5V6.7c0-.9.6-1.2 1.2-1.2h1.3V2.5h-2.1c-2.5 0-3.7 1.9-3.7 3.7v2.3H8v3.1h2.2v8.9h3.3v-8.9h2.4l.4-3.1h-2.8Z"/></svg>',
                                        'instagram' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 2.5h10A4.5 4.5 0 0 1 21.5 7v10A4.5 4.5 0 0 1 17 21.5H7A4.5 4.5 0 0 1 2.5 17V7A4.5 4.5 0 0 1 7 2.5Zm0 2A2.5 2.5 0 0 0 4.5 7v10A2.5 2.5 0 0 0 7 19.5h10A2.5 2.5 0 0 0 19.5 17V7A2.5 2.5 0 0 0 17 4.5H7Zm5 2.8A4.7 4.7 0 1 1 7.3 12.1 4.7 4.7 0 0 1 12 7.3Zm0 2A2.7 2.7 0 1 0 14.7 12.1 2.7 2.7 0 0 0 12 9.3Zm4.7-3.2a1.1 1.1 0 1 1-1.1 1.1 1.1 1.1 0 0 1 1.1-1.1Z"/></svg>',
                                        'youtube' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21.6 7.2a2.9 2.9 0 0 0-2-2C17.9 4.8 12 4.8 12 4.8s-5.9 0-7.6.4a2.9 2.9 0 0 0-2 2A31 31 0 0 0 2 12a31 31 0 0 0 .4 4.8 2.9 2.9 0 0 0 2 2c1.7.4 7.6.4 7.6.4s5.9 0 7.6-.4a2.9 2.9 0 0 0 2-2A31 31 0 0 0 22 12a31 31 0 0 0-.4-4.8ZM10 15.5v-7l6 3.5-6 3.5Z"/></svg>',
                                        'tiktok' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14.8 3.5c.3 1.4 1.2 2.6 2.5 3.4v2.6a6.1 6.1 0 0 1-2.4-.7v6.1a5.8 5.8 0 1 1-5.8-5.8c.2 0 .4 0 .6.1v2.7a3.1 3.1 0 1 0 1.9 3v-9.4h3.2Z"/></svg>',
                                        'whatsapp' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19.3 4.7A9.6 9.6 0 0 0 12.1 2a9.7 9.7 0 0 0-8.4 14.7L2 22l5.5-1.4a9.7 9.7 0 0 0 4.6 1.4h.1a9.7 9.7 0 0 0 6.9-16.3ZM12.2 17.7c-1.5 0-2.9-.4-4.2-1.1l-.3-.2-3.3.8.9-3.2-.2-.3A7.6 7.6 0 0 1 4.4 12a7.8 7.8 0 1 1 13.5 5.5l-.2.2-3.3.9.8-3.2-.2-.3A7.7 7.7 0 0 1 12.2 17.7Zm4.2-5.7c-.2-.1-1.2-.6-1.4-.7-.2-.1-.4-.1-.6.1-.1.2-.5.7-.6.8-.1.1-.2.2-.4.1-.2-.1-.9-.3-1.7-.9-.6-.5-1-1.1-1.1-1.3-.1-.2 0-.3.1-.4l.3-.3.2-.3c.1-.1.1-.2.2-.4.1-.1 0-.3 0-.4l-.1-.4C9.7 8.3 9.4 7.6 9.2 7.5c-.1-.1-.3-.1-.5-.1H8.6c-.2 0-.4.1-.6.3-.2.2-.8.8-.8 1.9s.8 2.1.9 2.3c.1.2 1.6 2.5 3.9 3.4.6.3 1.1.4 1.5.5.6.2 1.2.2 1.6.1.5-.1 1.5-.6 1.7-1.2.2-.6.2-1 .1-1.2-.1-.2-.2-.2-.4-.3Z"/></svg>',
                                    ];
                                    echo $svg[$key] ?? '';
                                    ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

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