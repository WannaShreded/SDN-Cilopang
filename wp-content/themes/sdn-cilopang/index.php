<?php get_header(); ?>

<main class="container section">

    <?php if (have_posts()) : ?>

        <?php while (have_posts()) : the_post(); ?>

            <article>

               <h3>
    <a
        href="<?php echo esc_url(get_permalink()); ?>"
        class="guru-card-link"
    >
        <?php the_title(); ?>
    </a>
</h3>

                <?php the_content(); ?>

            </article>

        <?php endwhile; ?>

    <?php endif; ?>

</main>

<?php get_footer(); ?>