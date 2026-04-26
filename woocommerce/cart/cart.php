<?php
/**
 * Custom WooCommerce Cart Table Template
 * Fully compatible with quantity update and remove
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );
?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
  <?php do_action( 'woocommerce_before_cart_table' ); ?>
    <div class="row g-4">
      <div class="col-lg-8">
        <div class="table-responsive bg-white p-4 shadow-sm custom-style-13">
          <table class="table align-middle mb-0 cart-table">
            <thead class="text-muted small text-uppercase">
              <tr>
                <th class="border-0 ps-0">Product</th>
                <th class="border-0">Price</th>
                <th class="border-0">Quantity</th>
                <th class="border-0">Subtotal</th>
                <th class="border-0 text-end pe-0"></th>
              </tr>
            </thead>
            <tbody>
              <?php do_action( 'woocommerce_before_cart_contents' ); ?>
                <?php 
                  foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                    $_product   = $cart_item['data'];
                    $product_id = $cart_item['product_id'];
                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) :
                      $product_permalink = $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '';
                      ?>
                      <tr>
                        <td class="ps-0 py-3">
                          <div class="d-flex align-items-center gap-3">
                            <div class="custom-style-14">
                              <?php
                                $thumbnail_id = $_product->get_image_id();
                                $featured_image_url = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : '';
                                if ( $featured_image_url ) {
                                  $img = $featured_image_url;
                                } else {
                                  $img = get_template_directory_uri().'/assets/theme/img/placeholder.webp';
                                }
                                echo '<a href="'.$product_permalink.'"><img class="custom-style-15" src="'.$img.'" alt="'.$_product->get_name().'" /></a>';
                              ?>
                            </div>
                            <div>
                              <h6 class="mb-0 fw-bold custom-style-16" >
                                <?php
                                  if ( ! $product_permalink ) {
                                    echo wp_kses_post( $_product->get_name() );
                                  } else {
                                    echo '<a href="' . esc_url( $product_permalink ) . '">' . wp_kses_post( $_product->get_name() ) . '</a>';
                                  }
                                ?>
                              </h6>
                              <?php
                                $sku = $_product->get_sku();
                                if ( !empty($sku) ) :
                                  echo '<small class="text-muted">SKU: '.$sku.'</small>';
                                endif;
                              ?>
                            </div>
                          </div>
                        </td>
                        <td class="fw-bold"><?php echo WC()->cart->get_product_price( $_product ); ?></td>
                        <td>
                          <?php
                            if ( $_product->is_sold_individually() ) {
                                echo '1';
                                echo '<input type="hidden" name="cart[' . $cart_item_key . '][qty]" value="1" />';
                            } else {
                                echo '<div class="d-flex align-items-center border rounded-pill px-2 custom-style-17">';
                                echo '<button type="button" class="btn btn-sm border-0 shadow-none qty-btn minus"> 
                                        <i class="bi bi-dash"></i>
                                      </button>';
                                woocommerce_quantity_input( array(
                                  'input_name'  => 'cart[' . $cart_item_key . '][qty]',
                                  'input_value' => $cart_item['quantity'],
                                  'max_value'   => $_product->get_max_purchase_quantity(),
                                  'min_value'   => '0',
                                  'classes'     => array('qty-input', 'form-control', 'form-control-sm', 'border-0', 'text-center', 'bg-transparent', 'custom-style-18'),
                                ), $_product, true );
                                echo '<button type="button" class="btn btn-sm border-0 shadow-none qty-btn plus">
                                        <i class="bi bi-plus"></i>
                                      </button>';

                                echo '</div>';
                            }
                          ?>
                        </td>
                        <td class="fw-bold custom-style-1" ><?php echo WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ); ?></td>
                        <td class="text-end pe-0">
                          <?php
                            echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                '<a href="%s" aria-label="%s" data-product_id="%s" data-product_sku="%s" class="btn btn-sm text-danger border-0 p-0"><i class="bi bi-trash fs-5"></i></a>',
                                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                __( 'Remove this item', 'woocommerce' ),
                                esc_attr( $product_id ),
                                esc_attr( $_product->get_sku() )
                            ), $cart_item_key );
                          ?>
                        </td>
                      </tr>
                    <?php 
                    endif; 
                  endforeach; 
                ?>
              <?php do_action( 'woocommerce_cart_contents' ); ?>
            </tbody>
          </table>
          <div class="d-flex justify-content-between mt-4">
            <a href="<?php echo wc_get_page_permalink( 'shop' ); ?>" class="btn btn-outline-rust px-4 rounded-pill">Continue Shopping</a>
            <button type="submit" class="btn btn-warm text-rust px-4 rounded-pill fw-bold" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update Cart', 'woocommerce' ); ?></button>
            <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
          </div>
        </div>
      </div>

      <div class="col-lg-4 cart-summery">
        <div class="bg-white p-4 shadow-sm custom-style-13" >
          <h5 class="fw-bold mb-4 custom-style-16" > <?php esc_html_e( 'Order Summary', 'woocommerce' ); ?> </h5>
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></span>
            <span class="fw-bold"><?php wc_cart_totals_subtotal_html(); ?></span>
          </div>
          <?php if ( wc_coupons_enabled() && WC()->cart->get_coupons() ) : ?>
            <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
              <div class="d-flex justify-content-between mb-2 cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                <span class="text-muted"><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
                <span class="text-success"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
          <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
            <div class="d-flex justify-content-between mb-2 shipment-table">
              <?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
              <?php wc_cart_totals_shipping_html(); ?>
              <?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>
            </div>
          <?php endif; ?>
          <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
            <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
              <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                <span class="text-muted"><?php echo esc_html( $tax->label ); ?></span>
                <span class="fw-bold"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
          <div class="border-bottom pb-3 mb-3"></div>
          <div class="d-flex justify-content-between mb-4 mt-2">
            <h5 class="fw-bold"><?php esc_html_e( 'Total', 'woocommerce' ); ?></h5>
            <h5 class="fw-bold custom-style-1" ><?php wc_cart_totals_order_total_html(); ?></h5>
          </div>
          <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="btn btn-rust w-100 py-3 fw-bold shadow-sm mb-3"><?php esc_html_e( 'Proceed to Checkout', 'woocommerce' ); ?></a>
          <p class="small text-center text-muted mb-0"><i class="bi bi-shield-check me-1"></i>Secure checkout & payments</p>
        </div>
        <?php if ( wc_coupons_enabled() ) : ?>
          <div class="mt-4 p-4 rounded-4 custom-style-19" >
            <h6 class="fw-bold mb-2">Have a coupon?</h6>
            <div class="input-group">
              <input type="text"
                name="coupon_code"
                class="form-control border-end-0 bg-white"
                id="coupon_code"
                value=""
                placeholder="<?php esc_attr_e( 'Promo code', 'woocommerce' ); ?>" />
              <button type="submit"
                class="btn btn-rust px-3 border-start-0"
                name="apply_coupon"
                value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>">
                <?php esc_html_e( 'Apply', 'woocommerce' ); ?>
              </button>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<?php do_action( 'woocommerce_after_cart' ); ?>