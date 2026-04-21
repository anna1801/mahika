<?php get_header(); ?>
    <?php 
        if(have_posts()):
            while(have_Posts()):the_post(); 
                $img = wp_get_attachment_url(get_post_thumbnail_id($post->ID), "full");
                the_content();
            endwhile;
        endif;
        wp_reset_query();
    ?>
<?php get_footer(); ?>