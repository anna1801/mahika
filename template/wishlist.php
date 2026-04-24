<?php function wishlist_table($wishlist_items) { ?>
  <div class="bg-white p-4 shadow-sm custom-style-13 wishlist">
    <div class="table-responsive">
      <?php if ( ! empty( $wishlist_items ) ) { ?>
        <table class="table align-middle mb-0">
          <thead class="text-muted small text-uppercase">
            <tr>
              <th class="border-0 ps-0">Product</th>
              <th class="border-0">Unit Price</th>
              <th class="border-0">Stock Status</th>
              <th class="border-0 text-end pe-0">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              foreach ( $wishlist_items as $item ) :
                $product = wc_get_product( $item['prod_id'] );
                if ( ! $product ) continue;
                $product_id = $product->get_id();
                $product_link = get_permalink( $product_id );
                $product_name = $product->get_name();
                ?>
                <tr>
                  <td class="ps-0 py-3">
                    <div class="d-flex align-items-center gap-3">
                      <a href="<?php echo esc_url( $item['remove_url'] ); ?>" class="btn btn-sm text-danger p-0 border-0 me-1"><i class="bi bi-x-circle"></i></a>
                      <div class="custom-style-70">
                        <?php 
                          if (has_post_thumbnail($product_id)) {
                            $image_url = wp_get_attachment_image_url( $product->get_image_id(), 'full' );
                          } else {
                            $image_url = get_template_directory_uri().'/assets/theme/img/placeholder.webp';
                          }
                        ?>
                        <img class="custom-style-71" src="<?php echo $image_url; ?>" alt="<?php echo $product_name; ?>" >
                      </div>
                      <div>
                      <a href="<?php echo esc_url($product_link); ?>"><h6 class="mb-0 fw-bold custom-style-16" ><?php echo $product_name; ?></h6></a>
                      </div>
                    </div>
                  </td>
                  <td class="fw-bold">
                    <?php
                      if ( $product->is_on_sale() ) {
                        echo '<span class="price">';
                        echo '<ins>' . wc_price( $product->get_sale_price() ) . '</ins> ';
                        echo '<del>' . wc_price( $product->get_regular_price() ) . '</del>';
                        echo '</span>';
                      } else {
                        echo '<span class="price">' . wc_price( $product->get_regular_price() ) . '</span>';
                      }
                    ?>
                  </td>
                  <td>
                    <?php 
                      if ( $product->is_in_stock() ) {
                        $class = 'bg-success-subtle text-success';
                        $text = 'In Stock';
                      } else {
                        $class = 'bg-danger-subtle text-danger';
                        $text = 'Out of Stock';
                      }
                    ?>
                    <span class="badge <?php echo $class; ?> px-3 py-2 rounded-pill"><?php echo $text; ?></span>
                  </td>
                  <td class="text-end pe-0">
                    <?php if ( $product->is_in_stock() ) : ?>
                      <a href="<?php echo esc_url($product->add_to_cart_url()); ?>"
                          data-quantity="1"
                          class="btn btn-rust btn-sm px-4 py-2 rounded-pill shadow-sm add_to_cart_button ajax_add_to_cart"
                          data-product_id="<?php echo $product_id; ?>"
                          data-product_sku="<?php echo esc_attr($product->get_sku()); ?>">
                              <?php echo esc_html($product->add_to_cart_text()); ?>
                          </a>
                    <?php else : ?>
                      <a href="#" class="btn btn-rust btn-sm px-4 py-2 rounded-pill shadow-sm disabled">Add to Cart</a>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php 
              endforeach; 
            ?>
          </tbody>
        </table>
      <?php } if ( empty( $wishlist_items ) ) { ?>
        <div class="text-center py-5">
          <i class="bi bi-heart fs-1 text-muted opacity-25"></i>
          <h4 class="mt-3">Your wishlist is empty</h4>
          <p class="text-muted">Explore our authentic spices and add them to your wishlist.</p>
          <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="btn btn-rust px-5 py-2 mt-2">Go to Shop</a>
        </div>
      <?php } ?>
    </div>
  </div>
<?php } ?>