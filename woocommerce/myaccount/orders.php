<?php
defined('ABSPATH') || exit;

$status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';

$args = [
  'customer' => get_current_user_id(),
  'limit'    => 50,
  'paginate' => true,
];

if ($status) {
  $args['status'] = $status;
}

$customer_orders = wc_get_orders($args);

?>

<div class="bg-white p-4 p-md-5 shadow-sm h-100 rounded-20">
  <?php if ($customer_orders->orders) : ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold mb-0">My Available Orders</h4>
      <div class="dropdown">
        <button class="btn btn-outline-rust btn-sm dropdown-toggle px-3" type="button"
          data-bs-toggle="dropdown">
          Filter by Status
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="<?php echo wc_get_account_endpoint_url('orders'); ?>">All Orders</a></li>
          <li><a class="dropdown-item" href="<?php echo wc_get_account_endpoint_url('orders'); ?>?status=processing">Processing</a></li>
          <li><a class="dropdown-item" href="<?php echo wc_get_account_endpoint_url('orders'); ?>?status=completed">Completed</a></li>
          <li><a class="dropdown-item" href="<?php echo wc_get_account_endpoint_url('orders'); ?>?status=cancelled">Cancelled</a></li>
        </ul>
      </div>
    </div>

    <div class="table-responsive my-account-order-table">
      <table class="table align-middle order-table">
        <thead>
          <tr>
            <th class="border-0 px-3 py-3 rounded-start">Order ID</th>
            <th class="border-0 py-3">Date</th>
            <th class="border-0 py-3">Status</th>
            <th class="border-0 py-3">Total</th>
            <th class="border-0 py-3 rounded-end text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($customer_orders->orders as $order) : 
            $order = wc_get_order($order);
          ?>
            <tr class="border-bottom">
              <td class="ps-3 py-4 fw-bold">
                #<?php echo $order->get_id(); ?>
              </td>

              <td class="py-4 text-muted">
                <?php echo wc_format_datetime($order->get_date_created()); ?>
              </td>

              <td class="py-4">
                <span class="status-badge status-<?php echo esc_attr($order->get_status()); ?>">
                  <?php echo wc_get_order_status_name($order->get_status()); ?>
                </span>
              </td>

              <td class="py-4 fw-bold text-rust">
                <?php echo $order->get_formatted_order_total(); ?>
                <small class="text-muted d-block fw-normal">
                  for <?php echo $order->get_item_count(); ?> items
                </small>
              </td>

              <td class="text-center py-4">
                <a href="<?php echo esc_url($order->get_view_order_url()); ?>" 
                    class="btn btn-sm btn-rust px-4 rounded-pill">
                    View Details
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else : ?>
    <div class="no_order text-center">
      <i class="bi bi-bag fs-1 text-muted opacity-25"></i>
      <h5 class="mt-3">No orders found.</h5>
      <p class="text-muted small">You haven't made any order yet.</p>
      <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-rust mt-3 px-4 rounded-pill">
          Browse Products
      </a>
    </div>
  <?php endif; ?>

  <!-- Pagination -->
  <?php if ($customer_orders->max_num_pages > 1) : ?>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4 pt-3 border-top">

      <div class="pagination-results-text"> 
        <?php
          $current_page = max(1, get_query_var('paged'));
          $per_page     = 50;

          $start = ($current_page - 1) * $per_page + 1;
          $end   = min($start + $per_page - 1, $customer_orders->total);
        ?>
        Showing <strong><?php echo $start; ?>–<?php echo $end; ?></strong> 
        of <strong><?php echo $customer_orders->total; ?></strong> results
      </div>

      <?php
        $current = max(1, get_query_var('paged'));
        $total   = $customer_orders->max_num_pages;

        $links = paginate_links([
            'total'      => $total,
            'current'    => $current,
            'type'       => 'array', 
            'prev_text'  => '<i class="bi bi-chevron-left"></i>',
            'next_text'  => '<i class="bi bi-chevron-right"></i>',
        ]);

        if ($links) :
      ?>
        <nav aria-label="Page navigation">
          <ul class="pagination custom-pagination mb-0">
            <?php foreach ($links as $link) : 
              $active = strpos($link, 'current') !== false ? 'active' : '';
              $disabled = strpos($link, 'dots') !== false ? 'disabled' : '';
              $link = str_replace('page-numbers', 'page-link', $link);
            ?>
              <li class="page-item <?php echo $active . ' ' . $disabled; ?>">
                <?php echo $link; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </nav>
      <?php endif; ?>

    </div>
  <?php endif; ?>

</div>