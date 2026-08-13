<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$categories = get_the_category();
$back_link = home_url('/');

if (!empty($categories)) {
    $primary_category = $categories[0];
    $back_link = get_category_link($primary_category);
}
?>

<main class="post-single-page">

    <section class="section">
        <div class="container">

            <?php while (have_posts()) : the_post(); ?>

                <article class="post-single-article">

                    <header class="post-single-header">

                        <?php if (!empty($categories)) : ?>
                            <div class="post-meta post-single-meta">
                                <?php foreach ($categories as $category) : ?>
                                    <a
                                        href="<?php echo esc_url(get_category_link($category)); ?>"
                                        class="post-category-link"
                                    >
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <h1 class="section-title post-single-title">
                            <?php the_title(); ?>
                        </h1>

                        <div class="post-meta">
                            <span><?php echo esc_html(get_the_date()); ?></span>
                        </div>

                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-single-featured-image">
                            <?php the_post_thumbnail('large', ['class' => 'post-featured-image']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>

                    <div class="post-single-actions">
                        <a href="<?php echo esc_url($back_link); ?>" class="btn btn-primary">
                            ← Kembali ke Kategori
                        </a>
                    </div>

                </article>

            <?php endwhile; ?>

        </div>
    </section>

</main>

<?php get_footer(); ?>
