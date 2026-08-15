<?php
// Archived: original archive-agenda.php moved to _archived_templates on 2026-08-15
// Original content preserved here for review/rollback.

get_header();
?>

<main class="agenda-archive-page">

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

    <section class="section section-agenda">
        <div class="container">

            <?php
            $query = new WP_Query([
                'post_type'      => 'agenda',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'meta_key'       => '_sdn_tanggal',
                'orderby'        => 'meta_value',
                'order'          => 'ASC',
            ]);

            if (!$query->have_posts()) :
                echo '<p>Belum ada agenda sekolah.</p>';
            else :

                echo '<div class="sdn-agenda-list">';

                while ($query->have_posts()) : $query->the_post();

                    $tanggal = get_post_meta(get_the_ID(), '_sdn_tanggal', true);
                    $waktu = get_post_meta(get_the_ID(), '_sdn_waktu', true);
                    $lokasi = get_post_meta(get_the_ID(), '_sdn_lokasi', true);

                    $permalink = get_permalink();
                    $aria = 'Buka detail agenda: ' . get_the_title();

                    echo '<a class="sdn-agenda-link" href="' . esc_url($permalink) . '" aria-label="' . esc_attr($aria) . '">';

                    ?>

                    <article class="sdn-agenda-card">

                        <div class="sdn-agenda-date">

                            <?php if ($tanggal) : ?>

                                <span class="sdn-agenda-day">
                                    <?php echo esc_html(date_i18n('d', strtotime($tanggal))); ?>
                                </span>

                                <span class="sdn-agenda-month">
                                    <?php echo esc_html(date_i18n('M', strtotime($tanggal))); ?>
                                </span>

                            <?php endif; ?>

                        </div>

                        <div class="sdn-agenda-content">

                            <h3>
                                <?php the_title(); ?>
                            </h3>

                            <?php if ($waktu) : ?>

                                <p>
                                    <strong>Waktu:</strong>
                                    <?php echo esc_html($waktu); ?>
                                </p>

                            <?php endif; ?>

                            <?php if ($lokasi) : ?>

                                <p>
                                    <strong>Lokasi:</strong>
                                    <?php echo esc_html($lokasi); ?>
                                </p>

                            <?php endif; ?>

                            <?php if (get_the_content()) : ?>

                                <div class="sdn-agenda-description">
                                    <?php the_content(); ?>
                                </div>

                            <?php endif; ?>

                        </div>

                    </article>

                    <?php

                    echo '</a>';

                endwhile;

                echo '</div>';

                wp_reset_postdata();

            endif;
            ?>

        </div>
    </section>

</main>

<?php
get_footer();
