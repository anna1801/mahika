<?php
add_action( 'wp_ajax_custom_ajax_add_to_cart', 'custom_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_custom_ajax_add_to_cart', 'custom_ajax_add_to_cart' );

function custom_ajax_add_to_cart() {
    if ( ! isset($_POST['product_id']) ) wp_send_json_error();

    $product_id = intval($_POST['product_id']);
    $quantity   = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    $cart_item_data = array();
    foreach ($_POST as $key => $value) {
        if ( strpos($key, 'attribute_') === 0 ) {
            $cart_item_data[ $key ] = sanitize_text_field($value);
        }
    }

    $added = WC()->cart->add_to_cart($product_id, $quantity, 0, array(), $cart_item_data);

    if ( $added ) {
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}

function ajax_addtocart_script() {
    wp_enqueue_script('ajax-addtocart', get_template_directory_uri() . '/ajax/js/add_to_cart.js', array('jquery'), null, true);

    wp_localize_script('ajax-addtocart', 'ajax_atc', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'ajax_addtocart_script');
?>