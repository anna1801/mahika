<?php get_header(); ?> 

<?php get_template_part('template/inner-hero'); ?>

<?php 
    if ( is_checkout() ) {
        if ( is_order_received_page() ) {
            $class = 'bg-cream';
        } else {
            $class = 'bg-light';
        }
    } else {
        $class = '';
    }
?>

<section class="py-5 <?php echo $class; ?> ">
    <div class="container py-4">
        <?php the_content(); ?>
    </div>
</section>

<?php get_footer(); ?>