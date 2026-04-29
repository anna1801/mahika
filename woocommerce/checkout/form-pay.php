<?php
defined( 'ABSPATH' ) || exit;

$totals = $order->get_order_item_totals(); 
?>

<form id="order_review" method="post">
  <div class="row g-3">

    <div class="col-lg-7 col-md-7 col-sm-12">
      <div class="bg-white p-4 p-md-5 shadow-sm rounded-20">
        <h5 class="fw-bold mb-3 ">Order Items</h5>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="bg-light">
              <tr>
                <th class="product-title border-0 small text-uppercase py-3 ps-3"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
                <th class="product-price border-0 small text-uppercase py-3"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
                <th class="product-quantity border-0 small text-uppercase py-3 text-end"><?php esc_html_e( 'Qty', 'woocommerce' ); ?></th>
                <th class="product-total border-0 small text-uppercase py-3 pe-3 text-end"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php if ( count( $order->get_items() ) > 0 ) : ?>
                <?php foreach ( $order->get_items() as $item_id => $item ) : ?>
                  <?php
                  $product = $item->get_product();
                  if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
                    continue;
                  }
                  ?>
                  <tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
                    <td class="product-name ps-3 py-3 border-0">
                      <div class="d-flex align-items-center gap-3">
                        <div class="product-item-img"><?php echo $product->get_image('full'); ?></div>
                        <div><h6 class="mb-0 fw-bold"><?php
                          echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false ) );

                          do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );

                          wc_display_item_meta( $item );

                          do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
                        ?></h6></div>
                      </div>
                    </td>
                    <td class="product-price py-3 border-0"><?php echo wc_price($product->get_price()); ?></td>
                    <td class="product-quantity py-3 border-0 text-end"><?php echo esc_html( $item->get_quantity() ); ?></td>
                    <td class="product-subtotal py-3 pe-3 border-0 text-end"><?php echo $order->get_formatted_line_subtotal( $item ); ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
            <tfoot>
              <?php if ( $totals ) : ?>
                <?php foreach ( $totals as $total ) : ?>
                  <tr>
                    <td colspan="3" class="text-end py-2 text-muted small class-<?php echo $total['type']; ?>"><?php echo $total['label']; ?></td>
                    <td class="text-end py-2 pe-3 value-<?php echo $total['type']; ?>"><?php echo $total['value']; ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tfoot>
          </table>
        </div>
      </div>
    </div>

    <div class="col-lg-5 col-md-5 col-sm-12">
      <div class="bg-white p-4 p-md-3 shadow-sm rounded-20">
        <?php do_action( 'woocommerce_pay_order_before_payment' ); ?>
        <div id="payment">
          <?php if ( $order->needs_payment() ) : ?>
            <ul class="wc_payment_methods payment_methods methods">
              <?php
              if ( ! empty( $available_gateways ) ) {
                foreach ( $available_gateways as $gateway ) {
                  wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
                }
              } else {
                echo '<li>';
                wc_print_notice( apply_filters( 'woocommerce_no_available_payment_methods_message', esc_html__( 'Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) ), 'notice' ); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment
                echo '</li>';
              }
              ?>
            </ul>
          <?php endif; ?>
          <div class="form-row">
            <input type="hidden" name="woocommerce_pay" value="1" />
            <?php wc_get_template( 'checkout/terms.php' ); ?>
            <?php do_action( 'woocommerce_pay_order_before_submit' ); ?>
            <?php echo apply_filters( 'woocommerce_pay_order_button_html', '<button type="submit" class="button alt' . esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ) . '" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); ?>
            <?php do_action( 'woocommerce_pay_order_after_submit' ); ?>
            <?php wp_nonce_field( 'woocommerce-pay', 'woocommerce-pay-nonce' ); ?>
          </div>
        </div>
      </div>
    </div>

  </div>
</form>