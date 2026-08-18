<?php get_header(); ?>

<main class="section">
    <div class="container">
        <header class="section-header 404-page">
            <span class="section-label"><?php esc_html_e('HALAMAN TIDAK DITEMUKAN', 'sdn-cilopang'); ?></span>
            <h1 class="section-title"><?php esc_html_e('Halaman Tidak Ditemukan', 'sdn-cilopang'); ?></h1>
            <p class="section-description"><?php esc_html_e('Halaman yang Anda cari tidak tersedia atau mungkin telah dipindahkan.', 'sdn-cilopang'); ?></p>
        </header>

        <div class="404-page-actions">
            <a class="btn btn-primary" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Kembali ke Beranda', 'sdn-cilopang'); ?></a>
        </div>
    </div>
</main>

<?php get_footer(); ?>
