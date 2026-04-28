<?php
defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();
$payment_methods = WC_Payment_Tokens::get_customer_tokens( $customer_id );
?>
<div class="bg-white p-4 p-md-5 shadow-sm h-100 rounded-20">
  <?php if ( ! empty( $payment_methods ) ) : ?>
    <?php foreach ( $payment_methods as $method ) : 
      $method_id = $method->get_id();
      $brand = $method->get_card_type();
      $last4 = $method->get_last4();
    ?>
      <h4 class="fw-bold mb-4">Saved Payment Methods</h4>
      <div class="p-3 border rounded-3 d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center gap-3">
          <i class="bi bi-credit-card-2-back fs-2 text-muted"></i>
          <div>
            <h6 class="mb-0 fw-bold"><?php echo esc_html( ucfirst($brand) ); ?> Card</h6>
            <small class="text-muted">Ending in •••• <?php echo esc_html( $last4 ); ?></small>
          </div>
        </div>
        <a href="<?php echo esc_url( wp_nonce_url(
              add_query_arg(
                  array(
                      'delete-payment-method' => $method_id,
                  ),
                  wc_get_account_endpoint_url( 'payment-methods' )
              ),
              'delete-payment-method-' . $method_id
          ) ); ?>"
          class="btn btn-sm text-danger"
          onclick="return confirm('Are you sure you want to delete this payment method?');">
          <i class="bi bi-trash"></i>
        </a>
      </div>
    <?php endforeach; ?>
    <a href="<?php echo esc_url( wc_get_endpoint_url( 'add-payment-method' ) ); ?>" 
      class="btn btn-outline-rust px-4 mt-3">
        + Add New Card
    </a>
  <?php else : ?>
    <div class="no_saved_payment text-center">
      <i class="bi bi-credit-card fs-1 text-muted opacity-25"></i>
      <h5 class="mt-3">No saved methods found.</h5>
      <p class="text-muted small">You haven't saved any payment methods yet.</p>
      <a href="<?php echo esc_url( wc_get_endpoint_url( 'add-payment-method' ) ); ?>" class="btn btn-rust mt-3 px-4 rounded-pill"> Add payment method </a>
    </div>
  <?php endif; ?>
</div>