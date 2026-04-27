<?php 
// header nav menu 
class Header_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        if ($depth === 0) {
            $output .= '<div class="megamenu"><div class="megamenu-content">';
        } elseif ($depth === 1) {
            $output .= '<ul>';
        }
    }
    function end_lvl(&$output, $depth = 0, $args = null) {
        if ($depth === 0) {
            $output .= '</div></div>';
        } elseif ($depth === 1) {
            $output .= '</ul>';
        }
    }
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = implode(' ', array_filter($classes));
        $has_children = in_array('menu-item-has-children', $classes);
        if ($depth === 0) {
            $li_classes = $class_names . ' nav-item';
            if ($has_children) {
                $li_classes .= ' has-megamenu';
            }
            $output .= '<li class="'. esc_attr($li_classes) .'">';
            $atts  = '';
            $atts .= ! empty($item->attr_title) ? ' title="'. esc_attr($item->attr_title) .'"' : '';
            $atts .= ! empty($item->target)     ? ' target="'. esc_attr($item->target) .'"' : '';
            $atts .= ! empty($item->xfn)        ? ' rel="'. esc_attr($item->xfn) .'"' : '';
            $atts .= ! empty($item->url)        ? ' href="'. esc_url($item->url) .'"' : '';
            $link_class = 'nav-link';
            if ($has_children) {
                $link_class .= ' dropdown-toggle';
            }
            $output .= '<a class="'. esc_attr($link_class) .'" '. $atts .'>';
            $output .= esc_html($item->title);
            $output .= '</a>';
        }
        elseif ($depth === 1) {
            $li_classes = $class_names . ' megamenu-col';
            $output .= '<div class="'. esc_attr($li_classes) .'">';
            $output .= '<h6>'. esc_html($item->title) .'</h6>';
        }
        elseif ($depth === 2) {
            $li_classes = $class_names;
            $output .= '<li class="'. esc_attr($li_classes) .'">';
            $atts  = ! empty($item->url) ? ' href="'. esc_url($item->url) .'"' : '';
            $output .= '<a'. $atts .'>';
            $output .= esc_html($item->title);
            $output .= '</a>';
            $output .= '</li>';
        }
    }
    function end_el(&$output, $item, $depth = 0, $args = null) {
        if ($depth === 0) {
            $output .= '</li>';
        } elseif ($depth === 1) {
            $output .= '</div>';
        }
    }
}

// footer nav menu
class Footer_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {}
    function end_lvl(&$output, $depth = 0, $args = null) {}
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = !empty($item->classes) ? implode(' ', $item->classes) : '';
        $output .= '<div class="' . esc_attr($classes) . '">';
        $output .= '<a href="' . esc_url($item->url) . '">';
        $output .= esc_html($item->title);
        $output .= '</a>';
    }
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= '</div>';
    }
}

// custom field Origin n product page to display use "$origin = get_post_meta($post->ID, '_product_origin', true);"
add_action('woocommerce_product_options_general_product_data', function () {
    woocommerce_wp_text_input([
        'id'          => '_product_origin',
        'label'       => 'Origin',
        'placeholder' => 'Enter product origin',
        'desc_tip'    => true,
        'description' => 'Add the origin of the product',
    ]);
});
add_action('woocommerce_process_product_meta', function ($post_id) {
    if (isset($_POST['_product_origin'])) {
        update_post_meta($post_id, '_product_origin', sanitize_text_field($_POST['_product_origin']));
    }
});

// Product Weight (shipping) in Gram 
add_filter('woocommerce_get_weight', function($weight, $product) {
    return $weight * 1000; // convert kg to grams
}, 10, 2);
add_filter('woocommerce_weight_unit', function() {
    return 'g';
});

// custom styl class for WYSIWYG Editor
function my_mce_before_init( $settings ) {
    $style_formats = array(
        array(
            'title' => 'font-size-15',
            'block' => 'span',
            'classes' => 'font-size-15',
            'wrapper' => true,
        ),
    );
    $settings['style_formats'] = json_encode( $style_formats );
    return $settings;
}
add_filter( 'tiny_mce_before_init', 'my_mce_before_init' );
function my_mce_buttons( $buttons ) {
    $position = array_search( 'bold', $buttons );
    if ( $position !== false ) {
        array_splice( $buttons, $position, 0, 'styleselect' );
    } else {
        array_unshift( $buttons, 'styleselect' );
    }
    return $buttons;
}
add_filter( 'mce_buttons', 'my_mce_buttons' );

// validate captcha code in contact form 7
add_filter('wpcf7_validate_text*', 'custom_captcha_validation', 20, 2);
function custom_captcha_validation($result, $tag) {
    if ($tag->name == 'your-captcha') {
        $generated = isset($_POST['captcha-generated']) ? $_POST['captcha-generated'] : '';
        $entered   = isset($_POST['your-captcha']) ? $_POST['your-captcha'] : '';
        if (strtoupper($entered) !== strtoupper($generated)) {
            $result->invalidate($tag, "Incorrect CAPTCHA, please try again.");
        }
    }
    return $result;
}

// Add class to body 
add_filter('body_class', function ($classes) {
    if (is_shop() || is_post_type_archive('product') ||  is_product_category()) {
        $classes[] = 'products-page';
    } elseif ( is_singular('product') ) {
        $classes[] = 'product-detail-page';
    } elseif( is_account_page() && is_user_logged_in() ) {
        $classes[] = 'bg-light';
    }
    return $classes;
});

// Save and Show phone on review table (dahboard)
add_action('comment_post', function ($comment_id) {
    if (isset($_POST['phone']) && !empty($_POST['phone'])) {
        $phone = sanitize_text_field($_POST['phone']);
        add_comment_meta($comment_id, 'phone', $phone);
    }
}, 10, 1);
add_action('add_meta_boxes_comment', function () {
    add_meta_box(
        'comment-phone',
        'Custom fields',
        function ($comment) {
            $phone = get_comment_meta($comment->comment_ID, 'phone', true);
            ?>
            <table class="form-table">
                <tbody>
                    <tr>
                        <td style="width: 10%;"><label for="phone">Phone</label></td>
                        <td style="width: 90%;"><input type="text" name="phone" value="<?php echo esc_html($phone ?: 'N/A'); ?>" id="phone" readonly style="width: 100%;"></td>
                    </tr>
                </tbody>
            </table>
            <?php
        },
        'comment',
        'normal',
        'high'
    );
});

// auto update number of products in cart to the header shop icon
add_filter( 'woocommerce_add_to_cart_fragments', 'update_cart_count_fragment' );
function update_cart_count_fragment( $fragments ) {
    ob_start();
    ?>
    <div class="auto-cart-count notification">
        <?php echo WC()->cart->get_cart_contents_count(); ?>
    </div>
    <?php
    $fragments['.auto-cart-count.notification'] = ob_get_clean();
    return $fragments;
}

// minicart ajax
add_filter( 'woocommerce_add_to_cart_fragments', 'custom_minicart_fragment' );
function custom_minicart_fragment( $fragments ) {
    ob_start();
    get_template_part('ajax/minicart');
    $fragments['.woocommerce-minicart-fragments'] = ob_get_clean();
    return $fragments;
}

// Ajax add to cart support
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_script( 'wc-cart-fragments' );
});

// force search.php template
add_filter('template_include', 'force_search_template', 99);
function force_search_template($template) {
    if (is_search()) {
        $new_template = locate_template(array('search.php'));
        if ($new_template) {
            return $new_template; 
        }
    }
    return $template;
}

// remove WooCommerce's wc_query effect during search
add_action('pre_get_posts', 'remove_wc_query_from_search', 5);
function remove_wc_query_from_search($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        $query->set('wc_query', false);
        $query->is_post_type_archive = false;
        $query->is_archive = false;
        $query->set('post_type', 'product');
    }
}

// Add classes for checkout form fields
add_filter('woocommerce_form_field_args', function($args) {
    $args['input_class'][] = 'form-control';
    $args['label_class'][] = 'form-label small fw-bold';
    return $args;
});

// Remove default classes from checkout form fields
add_filter('woocommerce_form_field', function($field, $key, $args, $value) {
    $field = str_replace(
        ['input-text', 'woocommerce-input-wrapper', 'form-row', 'validate-required'],
        '',
        $field
    );
    return $field;
}, 10, 4);

// hide coupon at checkout
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

// Validate custom registration fields (full name and Phone number)
add_action( 'woocommerce_register_post', function( $username, $email, $validation_errors ) {
    if ( isset($_POST['createaccount']) ) {
        return; // Skip validation if account created from checkout
    }
    if ( empty( $_POST['full_name'] ) || empty( trim( $_POST['full_name'] ) ) ) {
        $validation_errors->add( 'full_name_error', 'Please enter your full name.' );
    }
    if ( empty( $_POST['phone_number'] ) || empty( trim( $_POST['phone_number'] ) ) ) {
        $validation_errors->add( 'phone_number_error', 'Please enter your phone number.' );
    }
    return $validation_errors;
}, 10, 3 );

// Save custom registration fields  (full name and Phone number)
add_action( 'woocommerce_created_customer', function( $customer_id ) {
    if ( isset( $_POST['full_name'] ) ) {
        $full_name = sanitize_text_field( $_POST['full_name'] );
        update_user_meta( $customer_id, 'full_name', $full_name );
        $name_parts = explode( ' ', $full_name );
        $first_name = $name_parts[0];
        $last_name  = '';
        if ( count( $name_parts ) > 1 ) {
            array_shift( $name_parts );
            $last_name = implode( ' ', $name_parts );
        }
        update_user_meta( $customer_id, 'first_name', $first_name );
        update_user_meta( $customer_id, 'last_name', $last_name );
        update_user_meta( $customer_id, 'billing_first_name', $first_name );
        update_user_meta( $customer_id, 'billing_last_name', $last_name );
    }
    if ( isset( $_POST['phone_number'] ) ) {
        $phone = sanitize_text_field( $_POST['phone_number'] );
        update_user_meta( $customer_id, 'phone_number', $phone );
        update_user_meta( $customer_id, 'billing_phone', $phone ); 
    }
});

// Disable WooCommerce password strength requirement
add_filter( 'woocommerce_min_password_strength', function() {
    return 0; 
});

?>