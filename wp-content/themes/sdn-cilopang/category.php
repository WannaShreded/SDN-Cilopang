<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$queried_object = get_queried_object();
$category_name = is_object($queried_object) && isset($queried_object->name)
    ? $queried_object->name
    : single_cat_title('', false);

$category_description = category_description();
?>

<main class="post-archive-page">

    <section class="section post-archive-hero">
        <div class="container">
            <div class="section-header">
                <div class="section-label">KATEGORI</div>
                <h1 class="section-title"><?php echo esc_html($category_name); ?></h1>

                <?php if (!empty($category_description)) : ?>
                    <p class="section-description">
                        <?php echo wp_kses_post($category_description); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">

            <?php if (have_posts()) : ?>

                <div class="post-archive-grid">

                    <?php while (have_posts()) : the_post(); ?>

                        <?php
                        $post_categories = get_the_category();
                        $primary_category = !empty($post_categories)
                            ? $post_categories[0]
                            : null;
                        ?>

                        <article class="post-card">

                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php echo esc_url(get_permalink()); ?>">
                                    <?php the_post_thumbnail('medium', ['class' => 'post-card-image']); ?>
                                </a>
                            <?php endif; ?>

                            <div class="post-card-body">

                                <div class="post-meta">
                                    <span><?php echo esc_html(get_the_date()); ?></span>

                                    <?php if ($primary_category) : ?>
                                        <span class="post-meta-separator">•</span>
                                        <a
                                            href="<?php echo esc_url(get_category_link($primary_category)); ?>"
                                            class="post-category-link"
                                        >
                                            <?php echo esc_html($primary_category->name); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <h2 class="post-card-title">
                                    <a href="<?php echo esc_url(get_permalink()); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <p class="post-card-excerpt">
                                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), 22)); ?>
                                </p>

                                <a
                                    href="<?php echo esc_url(get_permalink()); ?>"
                                    class="btn btn-primary post-card-link"
                                >
                                    Selengkapnya
                                </a>

                            </div>

                        </article>

                    <?php endwhile; ?>

                </div>

                <?php the_posts_pagination([
                    'mid_size'  => 2,
                    'prev_text' => '← Sebelumnya',
                    'next_text' => 'Selanjutnya →',
                ]); ?>

            <?php else : ?>

                <p class="post-empty-state">
                    Belum ada konten di kategori ini.
                </p>

            <?php endif; ?>

        </div>
    </section>

</main>

<?php get_footer(); ?>
