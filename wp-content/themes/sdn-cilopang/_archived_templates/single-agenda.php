<?php
// Archived: original single-agenda.php moved to _archived_templates on 2026-08-15

get_header();

?>

<main class="agenda-single-page">

    <section class="section section-agenda-hero">
        <div class="container">
            <div class="section-header">
                <div class="section-label">AGENDA</div>
                <h1 class="section-title">
                    <?php the_title(); ?>
                </h1>
            </div>
        </div>
    </section>

    <section class="section section-agenda">
        <div class="container">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <?php
                $tanggal = get_post_meta(get_the_ID(), '_sdn_tanggal', true);
                $waktu = get_post_meta(get_the_ID(), '_sdn_waktu', true);
                $lokasi = get_post_meta(get_the_ID(), '_sdn_lokasi', true);
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

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="sdn-agenda-thumb">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="sdn-agenda-meta">
                            <?php if ($waktu) : ?>
                                <p><strong>Waktu:</strong> <?php echo esc_html($waktu); ?></p>
                            <?php endif; ?>

                            <?php if ($lokasi) : ?>
                                <p><strong>Lokasi:</strong> <?php echo esc_html($lokasi); ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="sdn-agenda-description">
                            <?php the_content(); ?>
                        </div>

                        <p style="margin-top:20px;"><a class="btn btn-primary" href="<?php echo esc_url(home_url('/agenda/')); ?>">&larr; Kembali ke Agenda</a></p>

                    </div>

                </article>

            <?php endwhile; endif; ?>

        </div>
    </section>

</main>

<?php
get_footer();
