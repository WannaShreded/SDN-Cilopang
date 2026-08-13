<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main class="guru-archive-page">

    <section class="section section-guru-hero">
        <div class="container">
            <div class="section-header">
                <div class="section-label">TENAGA PENDIDIK</div>
                <h1 class="section-title">Guru &amp; Tendik SDN Cilopang</h1>
                <p class="section-description">
                    Mengenal guru dan tenaga kependidikan yang mendampingi pembelajaran di SDN Cilopang.
                </p>
            </div>
        </div>
    </section>

    <section class="section section-guru">
        <div class="container">
            <?php echo do_shortcode('[sdn_daftar_guru]'); ?>
        </div>
    </section>

</main>

<?php
get_footer();
