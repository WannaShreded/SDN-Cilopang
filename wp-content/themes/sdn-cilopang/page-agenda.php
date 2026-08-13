<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main class="agenda-page">

    <section class="section section-agenda-hero">
        <div class="container">
            <div class="section-header">
                <div class="section-label">AGENDA SEKOLAH</div>
                <h1 class="section-title">Agenda Sekolah</h1>
                <p class="section-description">
                    Informasi kegiatan dan agenda yang diselenggarakan oleh SDN Cilopang.
                </p>
            </div>
        </div>
    </section>

    <section class="section page-agenda-list">
        <div class="container">
            <?php echo do_shortcode('[sdn_daftar_agenda]'); ?>
        </div>
    </section>

</main>

<?php
get_footer();
