<?php
defined('ABSPATH') || exit;

$order = wc_get_order($order_id);
?>

<div class="bg-white p-4 p-md-5 shadow-sm h-100 rounded-20">

  <div class="order-meta-card mb-4">
    <div class="row g-3">
      <div class="col-6 col-md-3">
        <small class="text-uppercase text-muted fw-bold d-block mb-1 custom-style-41">Order Number</small>
        <h6 class="fw-bold mb-0">#<?php echo $order->get_order_number(); ?></h6>
      </div>
      <div class="col-6 col-md-3">
        <small class="text-uppercase text-muted fw-bold d-block mb-1 custom-style-41">Date</small>
        <h6 class="fw-bold mb-0">
          <?php echo wc_format_datetime($order->get_date_created()); ?>
        </h6>
      </div>
      <div class="col-6 col-md-3">
        <small class="text-uppercase text-muted fw-bold d-block mb-1 custom-style-41">Total Amount</small>
        <h6 class="fw-bold mb-0">
          <?php echo $order->get_formatted_order_total(); ?>
        </h6>
      </div>
      <div class="col-6 col-md-3 text-md-end">
        <?php
          $status = $order->get_status();
          $status_classes = [
            'pending'    => 'bg-info-subtle text-info',
            'processing' => 'bg-warning-subtle text-warning',
            'on-hold'    => 'bg-secondary-subtle text-secondary',
            'completed'  => 'bg-success-subtle text-success',
            'cancelled'  => 'bg-danger-subtle text-danger',
            'refunded'   => 'bg-dark-subtle text-dark',
            'failed'     => 'bg-danger-subtle text-danger',
          ];
          $class = $status_classes[$status] ?? 'bg-light text-dark';
        ?>
        <span class="badge <?php echo esc_attr($class); ?> fw-bold px-3 py-2">
          <?php echo wc_get_order_status_name($order->get_status()); ?>
        </span>
      </div>
    </div>
  </div>

  <h5 class="fw-bold mb-3 mt-5">Order Items</h5>

  <div class="table-responsive">
    <table class="table align-middle">
      <thead class="bg-light">
        <tr>
          <th class="border-0 small text-uppercase py-3 ps-3">Product</th>
          <th class="border-0 small text-uppercase py-3">Price</th>
          <th class="border-0 small text-uppercase py-3">Qty</th>
          <th class="border-0 small text-uppercase py-3 text-end pe-3">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($order->get_items() as $item_id => $item):
          $product = $item->get_product();
          if (!$product) continue;
        ?>
          <tr>
            <td class="ps-3 py-3 border-0">
              <div class="d-flex align-items-center gap-3">
                <div class="product-item-img"><?php echo $product->get_image('full'); ?></div>
                <div><h6 class="mb-0 fw-bold"><?php echo esc_html($item->get_name()); ?></h6></div>
              </div>
            </td>
            <td class="py-3 border-0"><?php echo wc_price($product->get_price()); ?></td>
            <td class="py-3 border-0"> <?php echo $item->get_quantity(); ?></td>
            <td class="py-3 border-0 text-end pe-3"> <?php echo wc_price($item->get_total()); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3" class="text-end py-2 text-muted small"><?php esc_html_e('Subtotal', 'woocommerce'); ?></td>
          <td class="text-end py-2 pe-3"> <?php echo wc_price($order->get_subtotal()); ?> </td>
        </tr>
        <?php if ( $order->get_discount_total() > 0 ) : ?>
          <tr>
            <td colspan="3" class="text-end py-2 text-muted small">
              <?php esc_html_e('Coupon Discount', 'woocommerce'); ?>
            </td>
            <td class="text-end py-2 pe-3 text-success fw-bold">
              -<?php echo wc_price($order->get_discount_total()); ?>
            </td>
          </tr>
        <?php endif; ?>
        <?php if ( $order->get_shipping_method() ) : ?>
          <tr>
            <td colspan="3" class="text-end py-2 text-muted small">
              <?php esc_html_e('Shipping', 'woocommerce'); ?>
            </td>
            <td class="text-end py-2 pe-3">
              <?php echo wc_price($order->get_shipping_total()); ?>
            </td>
          </tr>
        <?php endif; ?>
        <?php if (wc_tax_enabled()) : ?>
          <?php foreach ($order->get_tax_totals() as $tax) : ?>
            <tr>
              <td colspan="3" class="text-end py-2 text-muted small">
                <?php echo esc_html($tax->label); ?>
              </td>
              <td class="text-end py-2 pe-3">
                <?php echo wp_kses_post($tax->formatted_amount); ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
        <tr>
          <td colspan="3" class="text-end py-3 fw-bold">Grand Total</td>
          <td class="text-end py-3 pe-3 fw-bold text-rust custom-style-42">
            <?php echo $order->get_formatted_order_total(); ?>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>

  <?php
    $actions = wc_get_account_orders_actions($order); 

    if ( isset($actions['view']) ) {
      unset($actions['view']);
    } 

    if ( ! empty($actions) ) : ?>
    <div class=" d-flex flex-wrap gap-2 justify-content-end payment-action">
      <?php foreach ( $actions as $key => $action ) :

        if ( $key === 'view' ) {
          continue;
        }

        $btn_class = 'btn-outline-rust'; 

        if ( $key === 'pay' ) {
          $btn_class = 'btn-success';
        } elseif ( $key === 'cancel' ) {
          $btn_class = 'btn-danger';
        } elseif ( $key === 'invoice' ) {
          $btn_class = 'btn-primary';
        }

      ?>
        <a href="<?php echo esc_url($action['url']); ?>"
          class="btn btn-sm rounded-pill px-4 <?php echo esc_attr($btn_class); ?>"
          aria-label="<?php echo esc_attr($action['name']); ?>">
          <?php echo esc_html($action['name']); ?>
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div class="row mt-5 g-4">
    <div class="col-md-6">
      <div class="p-4 border rounded-4 bg-light bg-opacity-50">
        <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
          <i class="bi bi-geo-alt text-rust"></i> Shipping Details
        </h6>
        <p class="mb-0 small text-muted lh-lg">
          <strong>
            <?php echo $order->get_formatted_shipping_full_name(); ?>
          </strong><br>
          <?php echo $order->get_shipping_address_1(); ?>, <?php echo $order->get_shipping_address_2(); ?><br>
          <?php echo $order->get_shipping_city(); ?> <br>
          Pin: <?php echo $order->get_shipping_postcode(); ?>,  
          <?php
            $country_code = $order->get_shipping_country();
            $state_code   = $order->get_shipping_state();
            $states = WC()->countries->get_states($country_code);
            echo isset($states[$state_code]) ? esc_html($states[$state_code]) : esc_html($state_code);
          ?>, 
          <?php
            $countries = WC()->countries->get_countries();
            $country_code = $order->get_shipping_country();
            echo isset($countries[$country_code]) ? esc_html($countries[$country_code]) : esc_html($country_code); 
          ?> <br>
          <?php if ( $order->get_billing_phone() ) : ?>
            T: <?php echo $order->get_billing_phone(); ?><br>
          <?php endif; ?>
          <?php if ( $order->get_billing_email() ) : ?>
            Email: <?php echo esc_html( $order->get_billing_email() ); ?>
          <?php endif; ?>
        </p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="p-4 border rounded-4 bg-light bg-opacity-50">
        <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
          <i class="bi bi-credit-card text-rust"></i> Payment Method
        </h6>
        <p class="mb-0 small text-muted">
          <?php echo $order->get_payment_method_title(); ?>
        </p>
        <?php if ($order->is_paid()) : ?>
          <p class="mb-0 small text-success fw-bold mt-1">
            <i class="bi bi-check-circle"></i> Transaction Successful
          </p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="text-center mt-5">
    <button class="btn btn-outline-rust rounded-pill px-5" onclick="window.print()">
      <i class="bi bi-printer me-2"></i>Print Invoice
    </button>
  </div>

</div>