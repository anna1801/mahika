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
        $output .= '<a href="' . esc_url($item->url) . '">';
        $output .= esc_html($item->title);
        $output .= '</a>';
    }
    function end_el(&$output, $item, $depth = 0, $args = null) {}
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


?>