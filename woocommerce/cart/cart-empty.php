<?php
/**
 * Custom WooCommerce Cart Table Template
 * Fully compatible with quantity update and remove
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="row">
    <div class="col-lg-12">
        <div class="custom-empty-cart text-center">
            <h2 class="wp-block-heading has-text-align-center with-empty-cart-icon wc-block-cart__empty-cart__title">Oops! Your cart is empty.</h2>
            <p>Explore our products and find something you love.</p>
            <div class="text-center mt-5 reveal visible animate__animated animate__fadeInUp" style="opacity: 1;">
                <a href="<?php echo wc_get_page_permalink( 'shop' ); ?>" target="" class="btn-rust text-decoration-none px-5 py-3">Continue Shopping</a>
            </div>
        </div>
    </div>
</div>