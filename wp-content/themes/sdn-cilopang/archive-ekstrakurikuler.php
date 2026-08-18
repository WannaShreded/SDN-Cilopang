<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main class="ekstrakurikuler-archive-page">

    <section class="section section-ekstrakurikuler-hero">
        <div class="container">
            <div class="section-header">
                <div class="section-label">EKSTRAKURIKULER</div>
                <h1 class="section-title">Ekstrakurikuler SDN Cilopang</h1>
                <p class="section-description">
                    Program ekstrakurikuler yang mendukung pengembangan minat dan bakat peserta didik.
                </p>
            </div>
        </div>
    </section>

    <section class="section section-ekstrakurikuler">
        <div class="container">

            <?php
            $query = new WP_Query([
                'post_type'      => 'ekstrakurikuler',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'title',
                'order'          => 'ASC',
            ]);

            if (!$query->have_posts()) :
                echo '<p>Belum ada data ekstrakurikuler.</p>';
            else :
                echo '<div class="sdn-ekstrakurikuler-grid">';

                while ($query->have_posts()) : $query->the_post();
                    $permalink = get_permalink();
                    $aria = 'Buka detail ekstrakurikuler: ' . get_the_title();
                    $pembina = get_post_meta(get_the_ID(), '_sdn_pembina', true);
                    $jadwal = get_post_meta(get_the_ID(), '_sdn_jadwal', true);
                    $tempat = get_post_meta(get_the_ID(), '_sdn_tempat', true);
                    ?>

                    <a class="sdn-ekstrakurikuler-link" href="<?php echo esc_url($permalink); ?>" aria-label="<?php echo esc_attr($aria); ?>">

                        <article class="sdn-ekstrakurikuler-card">

                            <div class="sdn-ekstrakurikuler-photo">

                                <?php if (has_post_thumbnail()) : ?>

                                    <?php the_post_thumbnail('large'); ?>

                                <?php else : ?>

                                    <div class="sdn-ekstrakurikuler-no-photo">
                                        Tidak ada foto
                                    </div>

                                <?php endif; ?>

                            </div>

                            <div class="sdn-ekstrakurikuler-content">

                                <h3>
                                    <?php the_title(); ?>
                                </h3>

                                <?php if ($pembina || $jadwal || $tempat) : ?>

                                    <div class="sdn-ekstrakurikuler-meta">

                                        <?php if ($pembina) : ?>
                                            <div class="sdn-ekstrakurikuler-meta-item">
                                                <span class="sdn-ekstrakurikuler-meta-label">Pembina</span>
                                                <span class="sdn-ekstrakurikuler-meta-value"><?php echo esc_html($pembina); ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($jadwal) : ?>
                                            <div class="sdn-ekstrakurikuler-meta-item">
                                                <span class="sdn-ekstrakurikuler-meta-label">Jadwal</span>
                                                <span class="sdn-ekstrakurikuler-meta-value"><?php echo esc_html($jadwal); ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($tempat) : ?>
                                            <div class="sdn-ekstrakurikuler-meta-item">
                                                <span class="sdn-ekstrakurikuler-meta-label">Tempat</span>
                                                <span class="sdn-ekstrakurikuler-meta-value"><?php echo esc_html($tempat); ?></span>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                <?php endif; ?>

                                <?php if (get_the_content()) : ?>
                                    <div class="sdn-ekstrakurikuler-description">
                                        <?php the_content(); ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                        </article>

                    </a>

                    <?php
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
