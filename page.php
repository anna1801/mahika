<?php get_header(); ?> 

<?php get_template_part('template/inner-hero'); ?>

<section class="py-5">
    <div class="container py-4">
        <?php the_content(); ?>
    </div>
</section>

<?php get_footer(); ?>