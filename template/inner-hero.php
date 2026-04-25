<?php
    if (is_page()) {
        $title = get_the_title();
        $current = get_the_title();
    } elseif (is_shop()) {
        $title = get_the_title(wc_get_page_id('shop'));
        $current = get_the_title(wc_get_page_id('shop'));
    } elseif ( is_singular('product') ) {
        $terms = get_the_terms( get_the_ID(), 'product_cat' );
        if ( $terms && ! is_wp_error( $terms ) ) {
            $names = [];
            foreach ( $terms as $term ) {
                $names[] = $term->name;
            }
            $title = implode(' / ', $names);
        }
        $current = get_the_title();
    }
?>
<section id="page-hero">
    <div class="page-hero-bg"></div>
    <div class="page-hero-overlay"></div>
    <div class="text-center reveal">
        <h1 class="page-hero-title"><span><?php echo $title; ?></span></h1>
        <div class="breadcrumb-wrap reveal custom-style-3" >
            <a href="<?php echo site_url(); ?>">Home</a>
            <span class="mx-2">/</span>
            <?php
                if ( is_singular('product') ) {
                    echo '<a href="'.get_permalink( wc_get_page_id( 'shop' ) ).'">'.get_the_title(wc_get_page_id('shop')).'</a>';
                    echo '<span class="mx-2">/</span>';
                }
            ?>
            <span><?php echo $current; ?></span>
        </div>
    </div>
</section>