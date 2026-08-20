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

                <!-- BUNGKUS KEDUANYA DI SINI (FLEXBOX CONTAINER) -->
                <div class="sdn-single-layout">
                    
                    <!-- Kolom Kiri: Gambar -->
                    <div class="sdn-single-image">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('large'); ?>
                        <?php else : ?>
                            <!-- Placeholder kalau fasilitas tidak ada foto -->
                            <div style="width: 100%; height: 300px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; border-radius: 12px; color: #64748b;">
                                Tidak ada foto
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Kolom Kanan: Konten & Tombol -->
                    <div class="sdn-single-info">
                        
                        <div class="sdn-single-description">
                            <?php the_content(); ?>
                        </div>

                        <p style="margin-top: 28px;">
                            <a class="btn btn-primary" href="<?php echo esc_url(home_url('/fasilitas/')); ?>">
                                &larr; Kembali ke Fasilitas
                            </a>
                        </p>

                    </div>

                </div>
                <!-- AKHIR BUNGKUS FLEXBOX -->

            <?php endwhile; endif; ?>

        </div>
    </section>

</main>

<?php
get_footer();