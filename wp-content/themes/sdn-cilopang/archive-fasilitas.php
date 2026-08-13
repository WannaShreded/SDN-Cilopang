<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main class="fasilitas-archive-page">

    <section class="section section-fasilitas-hero">
        <div class="container">
            <div class="section-header">
                <div class="section-label">FASILITAS SEKOLAH</div>
                <h1 class="section-title">Fasilitas SDN Cilopang</h1>
                <p class="section-description">
                    Berbagai fasilitas yang mendukung proses pembelajaran dan kegiatan siswa di SDN Cilopang.
                </p>
            </div>
        </div>
    </section>

    <section class="section section-fasilitas">
        <div class="container">

            <?php
            $query = new WP_Query([
                'post_type'      => 'fasilitas',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'title',
                'order'          => 'ASC',
            ]);

            if (!$query->have_posts()) :
                echo '<p>Belum ada data fasilitas.</p>';
            else :
                echo '<div class="sdn-fasilitas-grid">';

                while ($query->have_posts()) : $query->the_post();
                    $permalink = get_permalink();
                    $aria = 'Buka detail fasilitas: ' . get_the_title();
                    ?>

                    <a class="sdn-fasilitas-link" href="<?php echo esc_url($permalink); ?>" aria-label="<?php echo esc_attr($aria); ?>">

                        <article class="sdn-fasilitas-card">

                            <div class="sdn-fasilitas-photo">

                                <?php if (has_post_thumbnail()) : ?>

                                    <?php the_post_thumbnail('large'); ?>

                                <?php else : ?>

                                    <div class="sdn-fasilitas-no-photo">
                                        Tidak ada foto
                                    </div>

                                <?php endif; ?>

                            </div>

                            <div class="sdn-fasilitas-content">

                                <h3>
                                    <?php the_title(); ?>
                                </h3>

                                <?php if (get_the_content()) : ?>

                                    <div class="sdn-fasilitas-description">
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
