<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main class="ekstrakurikuler-single-page">

    <section class="section section-ekstrakurikuler-hero">
        <div class="container">
            <div class="section-header">
                <div class="section-label">EKSTRAKURIKULER</div>
                <h1 class="section-title">
                    <?php the_title(); ?>
                </h1>
            </div>
        </div>
    </section>

    <section class="section section-ekstrakurikuler">
        <div class="container">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <?php
                $pembina = get_post_meta(get_the_ID(), '_sdn_pembina', true);
                $jadwal = get_post_meta(get_the_ID(), '_sdn_jadwal', true);
                $tempat = get_post_meta(get_the_ID(), '_sdn_tempat', true);
                ?>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="sdn-ekstrakurikuler-single-photo">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="sdn-ekstrakurikuler-single-content">

                    <?php if ($pembina || $jadwal || $tempat) : ?>
                        <div class="sdn-ekstrakurikuler-meta">

                            <?php if ($pembina) : ?>
                                <p><strong>Pembina:</strong> <?php echo esc_html($pembina); ?></p>
                            <?php endif; ?>

                            <?php if ($jadwal) : ?>
                                <p><strong>Jadwal:</strong> <?php echo esc_html($jadwal); ?></p>
                            <?php endif; ?>

                            <?php if ($tempat) : ?>
                                <p><strong>Tempat:</strong> <?php echo esc_html($tempat); ?></p>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>

                    <?php if (get_the_content()) : ?>
                        <div class="sdn-ekstrakurikuler-description">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>

                    <p style="margin-top: 28px;">
                        <a class="btn btn-primary" href="<?php echo esc_url(home_url('/ekstrakurikuler/')); ?>">
                            &larr; Kembali ke Ekstrakurikuler
                        </a>
                    </p>

                </div>

            <?php endwhile; endif; ?>

        </div>
    </section>

</main>

<?php
get_footer();
