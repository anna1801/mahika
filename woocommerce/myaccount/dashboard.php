<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$current_user = wp_get_current_user();

$total_orders = wc_get_customer_order_count($current_user->ID);

$active_orders = wc_get_orders([
    'customer' => $current_user->ID,
    //'status'   => ['processing', 'on-hold'],
    'limit'    => -1,
]);

$total_active = count($active_orders);

$total_spent = wc_get_customer_total_spent($current_user->ID);
?>

<div class="bg-white p-4 p-md-5 shadow-sm h-100 rounded-20">

  <h4 class="fw-bold mb-4"> Hello <?php echo esc_html($current_user->display_name); ?>!</h4>

  <p class="text-muted lead">
    From your account dashboard you can view your 
    <a href="<?php echo wc_get_account_endpoint_url('orders'); ?>" class="text-rust fw-bold">recent orders</a>, 
    manage your 
    <a href="<?php echo wc_get_account_endpoint_url('edit-address'); ?>" class="text-rust fw-bold">addresses</a>, 
    and 
    <a href="<?php echo wc_get_account_endpoint_url('edit-account'); ?>" class="text-rust fw-bold">edit your account details</a>.
  </p>

  <div class="row g-3 mt-4">

    <div class="col-md-4">
      <div class="p-4 rounded-4 text-center custom-style-38">
        <h2 class="fw-bold text-rust mb-1">
          <?php echo str_pad($total_orders, 2, '0', STR_PAD_LEFT); ?>
        </h2>
        <small class="text-muted fw-bold text-uppercase">Total Orders</small>
      </div>
    </div>

    <div class="col-md-4">
      <div class="p-4 rounded-4 text-center custom-style-39">
        <h2 class="fw-bold text-success mb-1">
          <?php echo str_pad($total_active, 2, '0', STR_PAD_LEFT); ?>
        </h2>
        <small class="text-muted fw-bold text-uppercase">Active Orders</small>
      </div>
    </div>

    <div class="col-md-4">
      <div class="p-4 rounded-4 text-center custom-style-40">
        <h2 class="fw-bold text-warning mb-1">
          <?php echo wc_price($total_spent); ?>
        </h2>
        <small class="text-muted fw-bold text-uppercase">Total Spent</small>
      </div>
    </div>

  </div>

</div>