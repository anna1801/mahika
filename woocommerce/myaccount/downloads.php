<?php
defined( 'ABSPATH' ) || exit;

$downloads = WC()->customer->get_downloadable_products();
?>
<div class="bg-white p-4 p-md-5 shadow-sm h-100 text-center py-5 rounded-20 download-list">
  <?php if ( $downloads ) : ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold mb-0">My Available Downloads</h4>
    </div>
    <div class="table-responsive">
      <table class="table align-middle order-table">
        <thead>
          <tr>
            <th class="border-0 px-3 py-3 rounded-start text-left">Product</th>
            <th class="border-0 py-3">Downloads remaining</th>
            <th class="border-0 py-3">Expires</th>
            <th class="border-0 py-3 rounded-end text-center">Download</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ( $downloads as $download ) : ?>
            <tr>
              <td class="ps-3 py-4 fw-bold download-product text-left">
                <a href="<?php echo esc_url( $download['product_url'] ); ?>">
                  <?php echo esc_html( $download['product_name'] ); ?>
                </a>
              </td>
              <td class="py-4 text-muted download-remaining">
                <?php echo $download['downloads_remaining'] === '' ? '∞' : esc_html( $download['downloads_remaining'] ); ?>
              </td>

              <td class="py-4 download-expires">
                <?php echo empty( $download['access_expires'] ) ? 'Never' : date_i18n( get_option( 'date_format' ), strtotime( $download['access_expires'] ) ); ?>
              </td>
              <td class="download-file text-center">
                <a href="<?php echo esc_url( $download['download_url'] ); ?>" class="btn btn-sm btn-rust px-4 rounded-pill"><?php echo esc_html( $download['download_name'] ); ?></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else : ?>
    <div class="no_downloads">
        <i class="bi bi-cloud-download fs-1 text-muted opacity-25"></i>
        <h5 class="mt-3">No downloads available yet.</h5>
        <p class="text-muted small">You haven't made any downloadable purchases yet.</p>
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-rust mt-3 px-4 rounded-pill">
            Browse Products
        </a>
    </div>
  <?php endif; ?>
</div>