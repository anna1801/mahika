<?php
defined( 'ABSPATH' ) || exit;

// Ensure $order exists
if ( ! isset( $order ) || ! is_a( $order, 'WC_Order' ) ) {
    return;
}
?>

<div class="d-flex align-items-center justify-content-center py-5 custom-style-26 order-received">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="bg-white p-5 shadow-sm text-center custom-style-43">

          <main class="py-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-success-subtle text-success rounded-circle mb-3 custom-style-44">
              <i class="bi bi-check-circle-fill custom-style-45"></i>
            </div>

            <h2 class="fw-bold custom-style-16">
              Order Placed Successfully!
            </h2>

            <p class="text-muted">
              Thank you<?php echo $order->get_billing_first_name() ? ', ' . esc_html( $order->get_billing_first_name() ) : ''; ?>.
              We've received your order and are getting it ready for shipment.
            </p>
          </main>

          <div class="p-3 bg-light rounded-4 mb-4 text-start">

            <div class="d-flex justify-content-between mb-2">
              <span class="small text-muted">Order ID:</span>
              <span class="small fw-bold">
                #<?php echo esc_html( $order->get_order_number() ); ?>
              </span>
            </div>

            <div class="d-flex justify-content-between mb-2">
              <span class="small text-muted">Payment:</span>
              <span class="small fw-bold">
                <?php echo wp_kses_post( $order->get_formatted_order_total() ); ?>
              </span>
            </div>

            <div class="d-flex justify-content-between mb-2">
              <span class="small text-muted">Payment Method:</span>
              <span class="small fw-bold">
                <?php echo esc_html( $order->get_payment_method_title() ); ?>
              </span>
            </div>

            <!-- <div class="d-flex justify-content-between">
              <span class="small text-muted">Estimated Delivery:</span>
              <span class="small fw-bold text-success">
                Within 3–5 Days
              </span>
            </div> -->

          </div>

          <div class="d-grid gap-3">
            <a href="<?php echo esc_url( wc_get_account_endpoint_url('orders') ); ?>" class="btn btn-rust py-3 fw-bold rounded-3">
              Track My Order
            </a>

            <a href="<?php echo esc_url( wc_get_page_permalink('shop') ); ?>" class="btn btn-outline-dark py-3 fw-bold rounded-3">
              Continue Shopping
            </a>
          </div>

          <p class="mt-4 small text-muted">
            A confirmation email has been sent to your registered email address.
          </p>

        </div>
      </div>
    </div>
  </div>
</div>

<?php
  // do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );
  // do_action( 'woocommerce_thankyou', $order->get_id() );
?>