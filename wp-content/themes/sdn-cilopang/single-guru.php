<?php get_header(); ?>

<main class="guru-detail-page">

    <section class="section">

        <div class="container">

            <?php while (have_posts()) : the_post(); ?>

                <?php
                $nip = get_post_meta(
                    get_the_ID(),
                    '_sdn_nip',
                    true
                );

                $nuptk = get_post_meta(
                    get_the_ID(),
                    '_sdn_nuptk',
                    true
                );

                $jabatan = get_post_meta(
                    get_the_ID(),
                    '_sdn_jabatan',
                    true
                );

                $mapel = get_post_meta(
                    get_the_ID(),
                    '_sdn_mapel',
                    true
                );

                $status = get_post_meta(
                    get_the_ID(),
                    '_sdn_status',
                    true
                );
                ?>

                <div class="guru-detail">

                    <div class="guru-detail-photo">

                        <?php if (has_post_thumbnail()) : ?>

                            <?php
                            the_post_thumbnail(
                                'large',
                                [
                                    'class' => 'guru-detail-image'
                                ]
                            );
                            ?>

                        <?php else : ?>

                            <div class="guru-detail-no-photo">
                                Tidak ada foto
                            </div>

                        <?php endif; ?>

                    </div>


                    <div class="guru-detail-content">

                        <span class="section-label">
                            Tenaga Pendidik
                        </span>

                        <h1>
                            <?php the_title(); ?>
                        </h1>


                        <?php if ($jabatan) : ?>

                            <p class="guru-detail-position">
                                <?php echo esc_html($jabatan); ?>
                            </p>

                        <?php endif; ?>


                        <div class="guru-detail-info">

                            <?php if ($nip) : ?>

                                <div class="guru-info-row">
                                    <strong>NIP</strong>
                                    <span>
                                        <?php echo esc_html($nip); ?>
                                    </span>
                                </div>

                            <?php endif; ?>


                            <?php if ($nuptk) : ?>

                                <div class="guru-info-row">
                                    <strong>NUPTK</strong>
                                    <span>
                                        <?php echo esc_html($nuptk); ?>
                                    </span>
                                </div>

                            <?php endif; ?>


                            <?php if ($jabatan) : ?>

                                <div class="guru-info-row">
                                    <strong>Jabatan</strong>
                                    <span>
                                        <?php echo esc_html($jabatan); ?>
                                    </span>
                                </div>

                            <?php endif; ?>


                            <?php if ($mapel) : ?>

                                <div class="guru-info-row">
                                    <strong>Mata Pelajaran</strong>
                                    <span>
                                        <?php echo esc_html($mapel); ?>
                                    </span>
                                </div>

                            <?php endif; ?>


                            <?php if ($status) : ?>

                                <div class="guru-info-row">
                                    <strong>Status Kepegawaian</strong>
                                    <span>
                                        <?php echo esc_html($status); ?>
                                    </span>
                                </div>

                            <?php endif; ?>

                        </div>


                        <?php if (get_the_content()) : ?>

                            <div class="guru-detail-description">

                                <h2>
                                    Profil
                                </h2>

                                <?php the_content(); ?>

                            </div>

                        <?php endif; ?>


                        <a
                            href="<?php echo esc_url(
                                home_url('/guru/')
                            ); ?>"
                            class="btn btn-primary"
                        >
                            ← Kembali ke Data Guru
                        </a>

                    </div>

                </div>

            <?php endwhile; ?>

        </div>

    </section>

</main>

<?php get_footer(); ?>