<?php
  $id = get_the_ID();
  $product = wc_get_product($id);
  if ($product) :
    $title = get_the_title();
    $link = get_the_permalink();
    $regular_price = $product->get_regular_price();
    $sale_price    = $product->get_sale_price();
    ?>
    <div class="product-card h-100">
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
        <div class="product-body">
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
          <div class="product-name"><?php echo $title; ?></div>
          <!-- to do -->
          <div class="stars">★★★★★</div>
          <!-- to do end-->
          <div class="product-price mt-1">
            <?php
              if($product->is_on_sale()) {
                echo '<span class="now">'.wc_price($sale_price).'</span>';
                echo '<span class="was">'.wc_price($regular_price).'</span>';
              } else {
                echo '<span class="now">'.wc_price($regular_price).'</span>';
              }
            ?>
          </div>
          <div class="cart-btn">
            <a href="<?php echo esc_url($product->add_to_cart_url()); ?>"
            data-quantity="1"
            class="btn btn-cart add_to_cart_button ajax_add_to_cart"
            data-product_id="<?php echo esc_attr($product->get_id()); ?>"
            data-product_sku="<?php echo esc_attr($product->get_sku()); ?>">
              <i class="bi bi-cart-plus me-1"></i><?php echo esc_html($product->add_to_cart_text()); ?>
            </a>
          </div>
        </div>
      </a>
    </div>
    <?php 
  endif;
?>