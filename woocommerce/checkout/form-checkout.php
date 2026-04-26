<?php
defined('ABSPATH') || exit;

do_action('woocommerce_before_checkout_form', $checkout);

if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
?>

<?php if (!is_user_logged_in()) : ?>
  <div class="row g-5">
    <div class="col-lg-7">
      <div class="accordion checkout-accordion mb-4" id="checkoutAccordion">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#loginCollapse">
              <i class="bi bi-person-circle me-2"></i> Returning customer? Click here to login
            </button>
          </h2>
          <div id="loginCollapse" class="accordion-collapse collapse">
            <div class="accordion-body">
              <p class="small text-muted mb-4">If you have shopped with us before, please enter your details below.
                If you are a new customer, please proceed to the Billing section.</p>
              <form method="post" class="woocommerce-form woocommerce-form-login">
                <div class="row g-3">
                  <div class="col-md-6 mb-2">
                    <label class="form-label small fw-bold">Username or email *</label>
                    <input type="text" name="username" class="form-control" required />
                  </div>
                  <div class="col-md-6 mb-2">
                    <label class="form-label small fw-bold">Password *</label>
                    <input type="password" name="password" class="form-control" required />
                  </div>
                  <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-rust px-4 py-2 woocommerce-button" name="login" value="Login">Login</button>
                    <div class="form-check d-inline-block ms-3">
                      <input type="checkbox" class="form-check-input" name="rememberme" id="rememberMe" value="forever" />
                      <label class="form-check-label small" for="rememberMe">Remember Me</label>
                    </div>
                  </div>
                  <div class="col-12 mt-2">
                    <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="small text-rust text-decoration-none">Lost your password?</a>
                  </div>
                </div>
                <input type="hidden" name="redirect" value="<?php echo esc_url( wc_get_checkout_url() ); ?>" />
                <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php else : ?>
  <div class="mt-3"></div>
<?php endif; ?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
  <div class="row g-5">
    <div class="col-lg-7">
      <div class="bg-white p-4 p-md-5 h-100 shadow-sm custom-style-20">
        <h4 class="fw-bold mb-4 custom-style-16">Billing Details</h4>
        <div class="row g-3">
          <div class="col-md-6">
            <?php woocommerce_form_field('billing_first_name', $checkout->get_checkout_fields()['billing']['billing_first_name'], $checkout->get_value('billing_first_name')); ?>
          </div>
          <div class="col-md-6">
            <?php woocommerce_form_field('billing_last_name', $checkout->get_checkout_fields()['billing']['billing_last_name'], $checkout->get_value('billing_last_name')); ?>
          </div>
          <div class="col-12">
            <?php woocommerce_form_field('billing_country', $checkout->get_checkout_fields()['billing']['billing_country'], $checkout->get_value('billing_country')); ?>
          </div>
          <div class="col-12">
            <?php woocommerce_form_field('billing_address_1', $checkout->get_checkout_fields()['billing']['billing_address_1'], $checkout->get_value('billing_address_1')); ?>
            <?php woocommerce_form_field('billing_address_2', $checkout->get_checkout_fields()['billing']['billing_address_2'], $checkout->get_value('billing_address_2')); ?>
          </div>
          <div class="col-md-6">
            <?php woocommerce_form_field('billing_city', $checkout->get_checkout_fields()['billing']['billing_city'], $checkout->get_value('billing_city')); ?>
          </div>
          <div class="col-md-6">
            <?php woocommerce_form_field('billing_postcode', $checkout->get_checkout_fields()['billing']['billing_postcode'], $checkout->get_value('billing_postcode')); ?>
          </div>
          <div class="col-12">
            <?php woocommerce_form_field('billing_state', $checkout->get_checkout_fields()['billing']['billing_state'], $checkout->get_value('billing_state')); ?>
          </div>
          <div class="col-md-6">
            <?php woocommerce_form_field('billing_phone', $checkout->get_checkout_fields()['billing']['billing_phone'], $checkout->get_value('billing_phone')); ?>
          </div>
          <div class="col-md-6">
            <?php woocommerce_form_field('billing_email', $checkout->get_checkout_fields()['billing']['billing_email'], $checkout->get_value('billing_email')); ?>
          </div>

          <?php if (WC()->cart->needs_shipping_address()) : ?>
            <div class="col-12 mt-4">
              <div class="form-check mb-2">
                <input id="diffShipping" class="form-check-input" type="checkbox" name="ship_to_different_address" value="1">
                <label class="form-check-label fw-bold" for="diffShipping">Ship to a different address?</label>
              </div>
              <div class="shipping-details-wrap" id="shippingDetails">
                <h5 class="fw-bold mt-4 mb-3 custom-style-16" >Shipping Address</h5>
                <div class="row g-3">
                  <div class="col-md-6">
                    <?php woocommerce_form_field('shipping_first_name', $checkout->get_checkout_fields('shipping')['shipping_first_name'], $checkout->get_value('shipping_first_name')); ?>
                  </div>
                  <div class="col-md-6">
                    <?php woocommerce_form_field('shipping_last_name', $checkout->get_checkout_fields('shipping')['shipping_last_name'], $checkout->get_value('shipping_last_name')); ?>
                  </div>
                  <div class="col-12">
                    <?php woocommerce_form_field('shipping_country', $checkout->get_checkout_fields()['shipping']['shipping_country'], $checkout->get_value('shipping_country')); ?>
                  </div>
                  <div class="col-12">
                    <?php
                      woocommerce_form_field('shipping_address_1', $checkout->get_checkout_fields('shipping')['shipping_address_1'], $checkout->get_value('shipping_address_1'));
                      woocommerce_form_field('shipping_address_2', $checkout->get_checkout_fields('shipping')['shipping_address_2'], $checkout->get_value('shipping_address_2'));
                    ?>
                  </div>
                  <div class="col-12">
                    <?php woocommerce_form_field('shipping_state', $checkout->get_checkout_fields()['shipping']['shipping_state'], $checkout->get_value('shipping_state')); ?>
                  </div>
                  <div class="col-md-6">
                    <?php woocommerce_form_field('shipping_city', $checkout->get_checkout_fields('shipping')['shipping_city'], $checkout->get_value('shipping_city')); ?>
                  </div>
                  <div class="col-md-6">
                    <?php woocommerce_form_field('shipping_postcode', $checkout->get_checkout_fields('shipping')['shipping_postcode'], $checkout->get_value('shipping_postcode')); ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <div class="col-12 mt-4">
            <?php
              $field = $checkout->get_checkout_fields()['order']['order_comments'];
              $field['custom_attributes']['rows'] = 3;
              woocommerce_form_field(
                  'order_comments',
                  $field,
                  $checkout->get_value('order_comments')
              );
            ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-5 checkout-order-table">
      <div class="bg-white p-4 shadow-sm custom-style-20">
        <h5 class="fw-bold mb-4 custom-style-16">Your Order</h5>
        <div class="order-items-list mb-4">
          <?php foreach (WC()->cart->get_cart() as $cart_item) :
            $_product = $cart_item['data'];
          ?>
            <div class="d-flex justify-content-between mb-3">
              <span class="small">
                <?php echo $_product->get_name(); ?> × <?php echo $cart_item['quantity']; ?>
              </span>
              <span class="fw-bold small">
                <?php echo WC()->cart->get_product_subtotal($_product, $cart_item['quantity']); ?>
              </span>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="d-flex justify-content-between pt-3 border-top mb-2">
          <span class="text-muted small">Subtotal</span>
          <span class="fw-bold small"><?php wc_cart_totals_subtotal_html(); ?></span>
        </div>
        <?php if ( wc_coupons_enabled() && WC()->cart->get_coupons() ) : ?>
          <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
            <div class="d-flex justify-content-between pt-3 border-top mb-2 cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
              <span class="text-muted small"><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
              <span class="fw-bold small"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
        <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
          <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
            <div class="d-flex justify-content-between pt-3 border-top mb-2">
              <span class="text-muted small"><?php echo esc_html( $tax->label ); ?></span>
              <span class="fw-bold small"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
          <div class="d-flex justify-content-between mb-2 pb-3 border-bottom checkout-shipment">
            <?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
            <?php wc_cart_totals_shipping_html(); ?>
            <?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>
          </div>
        <?php endif; ?>
        <div class="d-flex justify-content-between mt-3">
          <h5 class="fw-bold"><?php esc_html_e( 'Total', 'woocommerce' ); ?></h5>
          <h5 class="fw-bold custom-style-1"><?php wc_cart_totals_order_total_html(); ?></h5>
        </div>
        <div class="mt-5 text-center">
          <img class="custom-style-21 checkout-logo" src="<?php echo get_template_directory_uri(); ?>/assets/theme/img/logo.png" >
          <p class="small text-muted mt-3">Your personal data will be used to process your order and for other
            purposes described in our privacy policy.</p>
        </div>
        <div class="mt-4 pt-4 border-top">
          <?php do_action('woocommerce_checkout_payment'); ?>
          <h5 class="fw-bold mb-3 custom-style-16" >Payment Method</h5>
          <?php
            $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
            if ( ! empty( $available_gateways ) ) :
                foreach ( $available_gateways as $gateway ) :
                    ?>
                      <div class="form-check mb-3 p-3 border rounded-3 custom-style-22" >
                        <input type="radio" id="<?php echo esc_attr( $gateway->id ); ?>" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" class="form-check-input ms-0 me-2" <?php checked( $gateway->chosen, true ); ?> />
                        <label class="form-check-label fw-bold custom-style-23" for="<?php echo esc_attr( $gateway->id ); ?>">
                            <?php echo esc_html( $gateway->get_title() ); ?>
                        </label>
                        <p class="small text-muted mb-0 mt-1"><?php echo wp_kses_post( $gateway->get_description() ); ?></p>
                      </div>
                    <?php
                endforeach;
            endif;
          ?>
          <?php do_action( 'woocommerce_review_order_before_submit' ); ?>
          <button type="submit" class="btn btn-rust w-100 py-3 mt-3 fw-bold shadow-sm rounded-3" name="woocommerce_checkout_place_order" id="place_order">
            Place Order <?php wc_cart_totals_order_total_html(); ?>
          </button>
          <?php do_action( 'woocommerce_review_order_after_submit' ); ?>
          <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
        </div>
      </div>
    </div>
  </div>
</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>