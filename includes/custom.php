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
    if (is_shop() || is_post_type_archive('product')) {
        $classes[] = 'products-page';
    } elseif ( is_singular('product') ) {
        $classes[] = 'product-detail-page';
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





?>