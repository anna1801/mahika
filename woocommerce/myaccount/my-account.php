<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$current_user = wp_get_current_user();
?>

<?php 
  // order status - for order-details page
  $order = null;
  if ( is_wc_endpoint_url('view-order') ) {
    $order_id = absint( get_query_var('view-order') );
    if ( $order_id ) {
      $order = wc_get_order( $order_id );
    }
  }
?>

<div class="row g-4">

  <div class="col-lg-3 reveal-left">
    <?php /* do_action( 'woocommerce_account_navigation' ); */ ?>
    <div class="account-sidebar bg-white p-3 shadow-sm rounded-20">
      <div class="p-3 text-center mb-4 border-bottom user-intro">
        <div class="mx-auto bg-warm rounded-circle d-flex align-items-center justify-content-center mb-3 text-rust custom-style-9">
          <?php echo strtoupper(substr($current_user->display_name, 0, 2)); ?>
        </div>
        <h6 class="fw-bold mb-0"><?php echo esc_html($current_user->display_name); ?></h6>
        <small class="text-muted"><?php echo esc_html($current_user->user_email); ?></small>
      </div>
      <div class="nav flex-column">
        <a href="<?php echo wc_get_account_endpoint_url('dashboard'); ?>" class="nav-link <?php echo !is_wc_endpoint_url() ? 'active' : ''; ?>"><i class="bi bi-speedometer2"></i>Dashboard</a>
        <a href="<?php echo wc_get_account_endpoint_url('orders'); ?>" class="nav-link <?php echo is_wc_endpoint_url('orders') ? 'active' : ''; ?>"><i class="bi bi-bag-check"></i>Orders</a>
        <a href="<?php echo wc_get_account_endpoint_url('downloads'); ?>" class="nav-link <?php echo is_wc_endpoint_url('downloads') ? 'active' : ''; ?>"><i class="bi bi-download"></i>Downloads</a>
        <a href="<?php echo wc_get_account_endpoint_url('payment-methods'); ?>" class="nav-link <?php echo is_wc_endpoint_url('payment-methods') ? 'active' : ''; ?>"><i class="bi bi-credit-card"></i>Payment Methods</a>
        <a href="<?php echo wc_get_account_endpoint_url('edit-address'); ?>" class="nav-link <?php echo is_wc_endpoint_url('edit-address') ? 'active' : ''; ?>"><i class="bi bi-geo-alt"></i>Addresses</a>
        <a href="<?php echo wc_get_account_endpoint_url('edit-account'); ?>" class="nav-link <?php echo is_wc_endpoint_url('edit-account') ? 'active' : ''; ?>"><i class="bi bi-person-gear"></i>Account Details</a>
        <a href="<?php echo wc_logout_url(); ?>" class="nav-link text-danger mt-3"><i class="bi bi-box-arrow-right"></i>Logout</a>
      </div>
    </div>

    <?php
      if ( $order ) :
        $status = $order->get_status();

        if ( ! in_array($status, [
          'pending',
          'on-hold',
          'cancelled',
          'refunded',
          'failed',
          'checkout-draft'
          ]) ) :

          $steps = [
            'pending'    => 'Order Placed',
            'processing' => 'Processing',
            'shipped'    => 'Shipped',
            'completed'  => 'Delivered',
          ];

          $status_flow = array_keys($steps);
          $current_index = array_search($status, $status_flow);
          ?>
          <div class="bg-white p-4 shadow-sm mt-4 rounded-20">
            <h6 class="fw-bold mb-3">Order Status</h6>
            <div class="timeline">
              <?php $i = 0; foreach ($steps as $key => $label):
                $step_index = array_search($key, $status_flow);
                $is_active = ($current_index !== false && $step_index !== false && $step_index <= $current_index);
                $status_time = get_post_meta($order->get_id(), '_status_time_' . $key, true);
                ?>
                <div class="timeline-item <?php echo $is_active ? 'active' : ''; ?>">
                  <small class="d-block fw-bold <?php echo $is_active ? 'text-rust' : 'text-muted'; ?>">
                    <?php echo esc_html($label); ?>
                  </small>
                  <small class="text-muted">
                    <?php
                      if ($key === 'pending') {
                        $date = $order->get_date_created();
                        echo $date ? $date->date('F j, g:i A') : '';
                      }
                      elseif ($key === 'completed') {
                        if ($status === 'completed' && $order->get_date_completed()) {
                          echo $order->get_date_completed()->date('F j, g:i A');
                        }
                      }
                      elseif ($status_time && $is_active) {
                        echo date('F j, g:i A', $status_time);
                      }
                      else {
                        echo ($is_active) ? 'In progress' : '';
                      }
                    ?>
                  </small>
                </div>
              <?php $i++; endforeach; ?>
            </div>
          </div>
          <?php 
        endif; 
      endif; 
    ?>
  </div>

  <div class="col-lg-9 reveal-right my-account-tab-content">
    <?php do_action( 'woocommerce_account_content' ); ?>
  </div>

</div>