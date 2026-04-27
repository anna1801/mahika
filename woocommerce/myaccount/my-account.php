<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$current_user = wp_get_current_user();
?>

<div class="row g-4">

  <div class="col-lg-3 reveal-left">
    <?php /* do_action( 'woocommerce_account_navigation' ); */ ?>
    <div class="account-sidebar bg-white p-3 shadow-sm rounded-20">
      <div class="p-3 text-center mb-4 border-bottom">
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
  </div>

  <div class="col-lg-9 reveal-right">
    <?php do_action( 'woocommerce_account_content' ); ?>
  </div>

</div>