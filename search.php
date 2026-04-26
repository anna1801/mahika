<?php get_header(); ?>

  <?php get_template_part('template/inner-hero'); ?>

  <section class="py-5">
    <div class="container py-4">
      <?php if ( have_posts() ) : ?>
        <!-- to do 
        <div class="toolbar mb-5 p-3 rounded-4 bg-white shadow-sm d-flex justify-content-between align-items-center">
          <span class="text-muted small">Showing 1-12 of 18 results</span>
          <select class="form-select w-auto border-0 bg-light small fw-bold">
            <option>Sort by: Newest Items</option>
            <option>Price: Low to High</option>
            <option>Price: High to Low</option>
          </select>
        </div>
        to do end-->
        <div class="row g-4">
          <?php while ( have_posts() ) : the_post(); ?>
            <?php
              $id = get_the_ID();
              $product = wc_get_product($id);
              $title = get_the_title();
              $link = get_the_permalink();
              $regular_price = $product->get_regular_price();
              $sale_price    = $product->get_sale_price();
            ?>
            <div class="col-6 col-md-3">
              <div class="product-card h-100 reveal">
                <button class="wishlist-btn"><?php echo do_shortcode('[yith_wcwl_add_to_wishlist class="mmm"]'); ?></button>
                <a href="<?php echo $link; ?>">
                  <div class="product-img-wrap">
                    <?php
                      if (has_post_thumbnail()) {
                        $image_url = get_the_post_thumbnail_url($id, 'full');
                      } else {
                        $image_url = get_template_directory_uri().'/assets/theme/img/placeholder.webp';
                      }
                    ?>
                    <img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" />
                  </div>
                </a>
                <div class="product-body search-body">
                  <?php 
                    $categories = wp_get_post_terms( $id, 'product_cat' );
                    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
                      echo '<ul class="badge-cats">';
                        $i = 1;
                        foreach ( $categories as $category ) :
                          if ( $category->parent == 0 ) :
                            $category_link = get_term_link( $category );
                            if($i > 1) {
                              $comma = ', ';
                            } else {
                              $comma = '';
                            }
                            echo '<li class="badge-cat">'.$comma.esc_html( $category->name ).'</li>';
                          endif;
                          $i++;
                        endforeach;
                      echo '</ul>';
                    endif;
                  ?>
                  <div class="product-name"><a href="<?php echo $link; ?>"><?php echo $title; ?></a></div>
                  <div class="product-price">
                    <?php
                      if($product->is_on_sale()) {
                        echo '<span class="now">'.wc_price($sale_price).'</span>';
                        echo '<span class="was">'.wc_price($regular_price).'</span>';
                      } else {
                        echo '<span class="now">'.wc_price($regular_price).'</span>';
                      }
                    ?>
                  </div>
                  <a href="<?php echo esc_url($product->add_to_cart_url()); ?>"
                    data-quantity="1"
                    class="btn btn-rust btn-sm mt-3 w-100 py-2 rounded-pill add_to_cart_button ajax_add_to_cart"
                    data-product_id="<?php echo esc_attr($product->get_id()); ?>"
                    data-product_sku="<?php echo esc_attr($product->get_sku()); ?>">
                    <?php echo esc_html($product->add_to_cart_text()); ?>
                  </a>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      <?php 
        else :
          echo '<h4 class="text-center">No products found</h4>';
        endif; 
      ?>
    </div>
  </section>

<?php get_footer(); ?>