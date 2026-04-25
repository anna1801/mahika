
<div class="cart-sidebar woocommerce-minicart-fragments" id="cartSidebar">
    <div class="cart-header">
        <h4>My Shopping Cart</h4>
        <button class="close-cart" id="closeCart"><i class="bi bi-x-lg"></i></button>
    </div>
    <?php if ( WC()->cart && ! WC()->cart->is_empty() ) : ?>
        <div class="cart-items">
            <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                $product   = $cart_item['data'];
                $product_id = $cart_item['product_id'];
                if ( $product && $product->exists() && $cart_item['quantity'] > 0 ) :
                    $product_name  = $product->get_name();
                    $thumbnail_id  = $product->get_image_id();
                    $thumbnail_url = wp_get_attachment_image_url( $thumbnail_id, 'full' );
                    $product_price = WC()->cart->get_product_price( $product );
                    $product_link  = $product->is_visible() ? $product->get_permalink( $cart_item ) : '';
                    ?>
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="cart-item-img-box">
                            <a href="<?php echo esc_url( $product_link ); ?>">
                                <img src="<?php echo $thumbnail_url; ?>" alt="<?php echo esc_html( $product_name ); ?>">
                            </a>
                        </div>
                        <div class="flex-grow-1">
                            <a href="<?php echo esc_url( $product_link ); ?>"><h6 class="mb-0 custom-style-12"><?php echo esc_html( $product_name ); ?></h6></a>
                            <small class="text-muted"><?php echo esc_html( $cart_item['quantity'] ); ?> x <?php echo $product_price; ?></small>
                        </div>
                        <a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>"
                            class="minicart-remove remove btn btn-sm text-danger border-0 p-0"
                            aria-label="<?php esc_attr_e( 'Remove this item', 'woocommerce' ); ?>"
                            data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>"
                            data-product_id="<?php echo esc_attr( $product_id ); ?>"
                            data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="cart-footer">
            <div class="cart-summary-line">
                <span>Subtotal</span>
                <span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
            </div>
            <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
                <div class="cart-summary-line">
                    <span>Shipping</span>
                    <span>
                        <?php 
                            $shipping_total = WC()->cart->get_shipping_total();
                            echo wc_price( $shipping_total );
                        ?>
                    </span>
                </div>
            <?php endif; ?>
            <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
                <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>

                    <div class="cart-summary-line">
                        <span><?php echo esc_html( $tax->label ); ?></span>
                        <span><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="cart-total"><span>Total</span><span><?php echo WC()->cart->get_total(); ?></span></div>
            <div class="cart-btns">
            <?php
                $cart_url     = wc_get_cart_url();
                $checkout_url = wc_get_checkout_url();
            ?>
            <a href="<?php echo $cart_url; ?>" class="btn btn-outline-dark rounded-pill py-2">View Cart</a>
            <a href="<?php echo $checkout_url; ?>" class="btn btn-rust py-2">Checkout</a>
            </div>
        </div>
    <?php else : ?>
        <div class="cart-items">
            <div class="text-center py-5">
                <i class="bi bi-cart-x fs-1 text-muted"></i>
                <p class="mt-2">Your cart is empty</p>
            </div>
        </div>
    <?php endif; ?>
</div>