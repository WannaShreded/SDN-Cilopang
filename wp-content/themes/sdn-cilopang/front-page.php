<?php

if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option(
    'sdn_cilopang_settings',
    []
);


/**
 * Identitas
 */

$nama_sekolah = $settings['nama_sekolah']
    ?? 'SDN Cilopang';

$tagline = $settings['tagline']
    ?? 'Sekolah Dasar Negeri Cilopang';


/**
 * Hero
 */

$hero_judul = $settings['hero_judul']
    ?? 'Selamat Datang di SD Negeri Cilopang';

$hero_judul_main = 'Selamat Datang';
$hero_judul_sub = 'di SD Negeri Cilopang';

if (preg_match('/^(.*?)\s+di\s+(.*)$/i', trim($hero_judul), $hero_matches)) {
    $hero_judul_main = trim($hero_matches[1]);
    $hero_judul_sub = 'di ' . trim($hero_matches[2]);
}

$hero_deskripsi = $settings['hero_deskripsi']
    ?? 'Membangun generasi yang berkarakter, berprestasi, dan siap menghadapi masa depan.';

$hero_image = !empty($settings['hero_image'])
    ? wp_get_attachment_image_url(
        $settings['hero_image'],
        'full'
    )
    : '';


/**
 * Profil
 */

$profil_judul = $settings['profil_judul']
    ?? 'Tentang SDN Cilopang';

$profil_deskripsi = $settings['profil_deskripsi']
    ?? 'Website resmi SDN Cilopang sebagai pusat informasi sekolah.';

$profil_image = !empty($settings['profil_image'])
    ? wp_get_attachment_image_url(
        $settings['profil_image'],
        'large'
    )
    : '';


/**
 * Kontak
 */

$alamat = $settings['alamat'] ?? '';
$telepon = $settings['telepon'] ?? '';
$email = $settings['email'] ?? '';


get_header();

?>

<main>


    <!-- =====================================================
         HERO
    ====================================================== -->

    <section
        class="hero"

        <?php if ($hero_image) : ?>

            style="
                background-image:
                url('<?php echo esc_url($hero_image); ?>');
            "

        <?php endif; ?>
    >

        <div class="hero-overlay"></div>


        <div class="container">

            <div class="hero-content">

                <span class="hero-label">

                    <?php
                    echo esc_html($tagline);
                    ?>

                </span>


                <h1 class="hero-title">
                    <span class="hero-title__main">
                        <?php echo esc_html($hero_judul_main); ?>
                    </span>
                    <span class="hero-title__sub">
                        <?php echo esc_html($hero_judul_sub); ?>
                    </span>
                </h1>


                <p class="hero-description">

                    <?php
                    echo esc_html($hero_deskripsi);
                    ?>

                </p>


                <a
                    href="<?php echo esc_url(
                        home_url('/profil-sekolah/')
                    ); ?>"
                    class="btn btn-primary"
                >
                    Mengenal Sekolah
                </a>

            </div>

        </div>

    </section>


    <!-- =====================================================
        STATISTIK SEKOLAH
    ====================================================== -->

    <section class="section section-statistik">

       <div class="container">

           <div class="sdn-statistik-grid">

               <div class="sdn-statistik-item">
                   <div class="sdn-statistik-number" data-count="<?php echo esc_attr(preg_replace('/[^0-9]/', '', $settings['jumlah_siswa'] ?? '0')); ?>">0</div>
                   <div class="sdn-statistik-label">Siswa Aktif</div>
               </div>

               <div class="sdn-statistik-item">
                   <?php
                   $jumlah_guru = wp_count_posts('guru');
                   $jumlah_guru_publish = $jumlah_guru->publish ?? 0;
                   ?>
                   <div class="sdn-statistik-number" data-count="<?php echo esc_attr($jumlah_guru_publish); ?>">0</div>
                   <div class="sdn-statistik-label">Guru & Tendik</div>
               </div>

               <div class="sdn-statistik-item">
                   <div class="sdn-statistik-number" data-count="<?php echo esc_attr(preg_replace('/[^0-9]/', '', $settings['tahun_berdiri'] ?? '0')); ?>">0</div>
                   <div class="sdn-statistik-label">Tahun Berdiri</div>
               </div>

               <div class="sdn-statistik-item">
                   <div class="sdn-statistik-number sdn-statistik-text">
                       <?php echo esc_html($settings['akreditasi'] ?? '-'); ?>
                   </div>
                   <div class="sdn-statistik-label">Akreditasi</div>
               </div>

           </div>

       </div>

    </section>


    <!-- =====================================================
         PROFIL SEKOLAH
    ====================================================== -->

    <section class="section section-profil">

        <div class="container">

            <div class="section-header">

                <div class="section-label">
                    Tentang Kami
                </div>


                <h2 class="section-title">

                    <?php
                    echo esc_html($profil_judul);
                    ?>

                </h2>


                <p class="section-description">

                    <?php
                    echo nl2br(
                        esc_html($profil_deskripsi)
                    );
                    ?>

                </p>

            </div>


            <div class="sdn-profile-grid">

                <div class="sdn-profile-photo">
                    <?php if ($profil_image) : ?>
                        <img
                            src="<?php echo esc_url($profil_image); ?>"
                            alt="<?php echo esc_attr($profil_judul); ?>"
                        >
                    <?php else : ?>
                        <div class="sdn-profile-no-photo" aria-hidden="true"></div>
                    <?php endif; ?>
                </div>

                <div class="sdn-profile-content">

                    <h3 class="sdn-profile-name">
                        <?php echo esc_html($nama_sekolah); ?>
                    </h3>

                    <div class="sdn-profile-text">
                        <?php
                        echo nl2br(
                            esc_html($profil_deskripsi)
                        );
                        ?>
                    </div>

                </div>

            </div>

        </div>

    </section>

        <!-- =====================================================
         GURU & TENAGA KEPENDIDIKAN
    ====================================================== -->

    <section class="section section-guru">

    <div class="container">

        <div class="section-header">

            <div class="section-label">
                Tenaga Pendidik
            </div>

            <h2 class="section-title">
                Guru & Tenaga Kependidikan
            </h2>

            <p class="section-description">
                Mengenal para pendidik yang berperan
                dalam membimbing dan mengembangkan
                potensi peserta didik SDN Cilopang.
            </p>

        </div>

        <?php
        echo do_shortcode('[sdn_daftar_guru]');
        ?>

    </div>

</section>

<!-- =====================================================
     FASILITAS SEKOLAH
====================================================== -->

<section class="section section-fasilitas">

    <div class="container">

        <div class="section-header">

            <div class="section-label">
                Fasilitas Sekolah
            </div>

            <h2 class="section-title">
                Fasilitas SDN Cilopang
            </h2>

            <p class="section-description">
                Berbagai fasilitas yang mendukung proses
                pembelajaran dan kegiatan siswa di
                SDN Cilopang.
            </p>

        </div>


        <?php
        echo do_shortcode('[sdn_daftar_fasilitas]');
        ?>

    </div>

</section>
    <!-- =====================================================
         EKSTRAKURIKULER
    ====================================================== -->

    <section class="section section-ekstrakurikuler">

        <div class="container">

            <div class="section-header">

                <div class="section-label">
                    KEGIATAN SISWA
                </div>

                <h2 class="section-title">
                    Ekstrakurikuler
                </h2>

                <p class="section-description">
                    Berbagai kegiatan ekstrakurikuler untuk mengembangkan
                    minat, bakat, kreativitas, dan karakter peserta didik.
                </p>

            </div>

            <?php
            echo do_shortcode('[sdn_daftar_ekstrakurikuler]');
            ?>

        </div>

    </section>

</main>


<?php get_footer(); ?>