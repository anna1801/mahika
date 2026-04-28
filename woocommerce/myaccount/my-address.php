<?php
defined('ABSPATH') || exit;

$customer_id = get_current_user_id();

$billing  = wc_get_account_formatted_address('billing', $customer_id);
$shipping = wc_get_account_formatted_address('shipping', $customer_id);
?>

<div class="bg-white p-4 p-md-5 shadow-sm h-100 rounded-20">
  
  <h4 class="fw-bold mb-4">Your Addresses</h4>

  <div class="row">

    <!-- Billing Address -->
    <div class="col-md-6 mb-3">
      <div class="p-4 border rounded-4">
        
        <h6 class="fw-bold mb-3 border-bottom pb-2">
          Billing Address
        </h6>

        <p class="small text-muted mb-0">
          <?php 
          if ($billing) {
              echo wp_kses_post($billing);
          } else {
              echo 'You have not set up a billing address yet.';
          }
          ?>
        </p>

        <a class="btn btn-link px-0 text-rust small fw-bold mt-2"
           href="<?php echo esc_url(wc_get_endpoint_url('edit-address', 'billing')); ?>">
          Edit Address
        </a>

      </div>
    </div>

    <!-- Shipping Address -->
    <div class="col-md-6">
      <div class="p-4 border rounded-4">

        <h6 class="fw-bold mb-3 border-bottom pb-2">
          Shipping Address
        </h6>

        <p class="small text-muted mb-0">
          <?php 
          if ($shipping) {
              echo wp_kses_post($shipping);
          } else {
              echo 'Same as billing address or not set.';
          }
          ?>
        </p>

        <a class="btn btn-link px-0 text-rust small fw-bold mt-2"
           href="<?php echo esc_url(wc_get_endpoint_url('edit-address', 'shipping')); ?>">
          Edit Address
        </a>

      </div>
    </div>

  </div>
</div>