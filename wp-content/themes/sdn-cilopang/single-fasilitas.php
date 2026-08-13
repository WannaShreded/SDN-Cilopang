<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main class="fasilitas-single-page">

    <section class="section section-fasilitas-hero">
        <div class="container">
            <div class="section-header">
                <div class="section-label">FASILITAS</div>
                <h1 class="section-title">
                    <?php the_title(); ?>
                </h1>
            </div>
        </div>
    </section>

    <section class="section section-fasilitas">
        <div class="container">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="sdn-fasilitas-single-photo">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="sdn-fasilitas-single-content">

                    <?php the_content(); ?>

                    <p style="margin-top: 28px;">
                        <a class="btn btn-primary" href="<?php echo esc_url(home_url('/fasilitas/')); ?>">
                            &larr; Kembali ke Fasilitas
                        </a>
                    </p>

                </div>

            <?php endwhile; endif; ?>

        </div>
    </section>

</main>

<?php
get_footer();
